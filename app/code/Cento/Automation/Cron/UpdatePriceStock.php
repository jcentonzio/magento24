<?php

declare(strict_types=1);

namespace Cento\Automation\Cron;
use Cento\Automation\Helper\PriceStock;
use Cento\Automation\Helper\Service;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class UpdatePriceStock
{

    protected $logger;
    protected $_service;
    protected $_appState;
    protected $_priceStock;

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
        PriceStock $priceStock
    )
    {
        $this->logger = $logger;
        $this->_collection = $collection;
        $this->_service = $service;
        $this->_appState = $appState;
        $this->_priceStock = $priceStock;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {

        $this->logger->addInfo("Cronjob UpdateProduct is executed.");

        $this->_appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

        $products = $this->_collection->addAttributeToSelect('*')->addFilter('attribute_set_id', 4, 'eq')->load();

        foreach ($products as $product) {

            $sku = $product->getData('sku');

            $sourceProduct = $this->_service->updateProduct($sku);

            $sourceProduct = json_decode($sourceProduct, true);

            $sourceProduct = $sourceProduct['datos']['0'];

            $this->_priceStock->execute($product->getData('entity_id'), $sourceProduct);

        }

    }
}

