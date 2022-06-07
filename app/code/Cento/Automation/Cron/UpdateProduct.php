<?php

declare(strict_types=1);

namespace Cento\Automation\Cron;
use Cento\Automation\Helper\CreateProduct;
use Cento\Automation\Helper\Service;
use Magento\Catalog\Model\ResourceModel\Product\Collection;

class UpdateProduct
{

    protected $logger;
    protected $_service;
    protected $_appState;
    protected $_productRepository;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        Collection $collection,
        Service $service,
        \Magento\Framework\App\State $appState
    )
    {
        $this->logger = $logger;
        $this->_collection = $collection;
        $this->_service = $service;
        $this->_appState = $appState;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob UpdateProduct is executed.");

        $this->_appState->setAreaCode('adminhtml');

        $products = $this->_collection->addAttributeToSelect('*')->addFilter('attribute_set_id', 31, 'eq')->load();

        foreach ($products as $product) {
            var_dump($product->getData('sku'));die();
        }

    }
}

