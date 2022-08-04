<?php

declare(strict_types=1);

namespace Cento\Automation\Cron;
use Cento\Automation\Helper\PriceStock;
use Cento\Automation\Helper\Service;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\App\Filesystem\DirectoryList;

class UpdatePriceStock
{

    protected $logger;
    protected $_service;
    protected $_appState;
    protected $_priceStock;

    protected $filesystem;
    protected $customerFactory;
    protected $directory;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        Collection $collection,
        Service $service,
        \Magento\Framework\App\State $appState,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\Customer\Model\CustomerFactory $customerFactory,
        PriceStock $priceStock
    )
    {
        $this->logger = $logger;
        $this->_collection = $collection;
        $this->_service = $service;
        $this->_appState = $appState;
        $this->_priceStock = $priceStock;
        $this->customerFactory = $customerFactory;
        $this->directory = $filesystem->getDirectoryWrite(DirectoryList::VAR_DIR);
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {

        try {
            $this->logger->addInfo("Cronjob UpdateProduct is executed.");

            $this->_appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

            $products = $this->_collection->addAttributeToSelect('*')->addFilter('attribute_set_id', 4, 'eq')->load();

            $filepath= 'export/price_stock.csv';
            $filepath2 = 'export/avanced_price.csv';
            $this->directory->create('export');
            $stream = $this->directory->openFile($filepath, 'w+');
            $stream2 = $this->directory->openFile($filepath2, 'w+');
            $stream->lock();
            $stream2->lock();

            $header = ['sku', 'price', 'qty', 'is_in_stock'];
            $header2 = ['sku','tier_price_website', 'tier_price_customer_group', 'tier_price_qty', 'tier_price', 'tier_price_value_type'];
            $stream->writeCsv($header);
            $stream2->writeCsv($header2);

            $i = 0;
            foreach ($products as $product) {

                echo "Actualizando producto {$product->getSku()} \n";

                $sku = $product->getData('sku');

                $sourceProduct = $this->_service->updateProduct($sku);

                if(!isset($sourceProduct)) {
                    $i++;
                    if($i < 5) {
                        continue;
                    } else {
                        exit;
                    }
                } else {
                    $i = 0;
                }

                $sourceProduct = json_decode($sourceProduct, true);

                $sourceProduct = $sourceProduct['datos']['0'];

                if($sourceProduct['stock'] > 0) {
                    $stockStatus = 1;
                } else {
                    $stockStatus = 0;
                }

                //$this->_priceStock->execute($product->getData('entity_id'), $sourceProduct);

                $data = [];
                $data2 = [];
                $data[] = $product->getSku();
                $data[] = $sourceProduct['minoristabruto'];
                $data[] = $sourceProduct['stock'];
                $data[] = $stockStatus;
                $data2[] = $product->getSku();
                $data2[] = "All Websites [CLP]";
                $data2[] = "Mayorista";
                $data2[] = "1";
                $data2[] = $sourceProduct['mayoristaneto'];
                $data2[] = "Fixed";
                $stream->writeCsv($data);
                $stream2->writeCsv($data2);

            }
        } catch (\Exception $exception){
            echo "{$exception->getMessage()} \n";
        }

    }
}

