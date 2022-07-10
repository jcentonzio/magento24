<?php

declare(strict_types=1);

namespace Cento\Automation\Cron;
use Cento\Automation\Helper\PriceStock;
use Cento\Automation\Helper\Service;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Cento\Automation\Helper\UpdateProductImages;

class UpdateImages
{

    protected $logger;
    protected $_service;
    protected $_appState;
    protected $_updateProductImages;

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
        UpdateProductImages $updateProductImages
    )
    {
        $this->logger = $logger;
        $this->_collection = $collection;
        $this->_service = $service;
        $this->_appState = $appState;
        $this->_updateProductImages = $updateProductImages;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {

        $this->logger->addInfo("Cronjob UpdateImages is executed.");

        $this->_appState->setAreaCode(\Magento\Framework\App\Area::AREA_GLOBAL);

        $products = $this->_collection->addAttributeToSelect('*')->addFilter('attribute_set_id', 4, 'eq')->load();

        foreach ($products as $product) {

            if ($product->getThumbnail() != '' && $product->getThumbnail() != 'no_selection') {
                $this->_updateProductImages->execute($product->getData('entity_id'));
            }

        }

    }
}

