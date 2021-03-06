<?php

declare(strict_types=1);

namespace Cento\Automation\Cron;
use Cento\Automation\Helper\UpdateProduct;
use Cento\Automation\Helper\Service;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class ActualizeProduct
{

    protected $logger;
    protected $_service;
    protected $_appState;
    protected $_updateProduct;

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
        UpdateProduct $updateProduct
    )
    {
        $this->logger = $logger;
        $this->_collection = $collection;
        $this->_service = $service;
        $this->_appState = $appState;
        $this->_updateProduct = $updateProduct;
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

            $this->_updateProduct->execute($product->getData('entity_id'), $sourceProduct);

        }

    }
}

