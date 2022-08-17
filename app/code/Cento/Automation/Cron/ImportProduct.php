<?php

declare(strict_types=1);

namespace Cento\Automation\Cron;
use Cento\Automation\Helper\CreateProduct;
use Cento\Automation\Helper\Service;

class ImportProduct
{

    protected $logger;
    protected $_createProduct;
    protected $_service;
    protected $_appState;

    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        CreateProduct $createProduct,
        Service $service,
        \Magento\Framework\App\State $appState
    )
    {
        $this->logger = $logger;
        $this->_createProduct = $createProduct;
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
        $this->logger->addInfo("Cronjob ImportProduct is executed.");

        try {
            $this->_appState->setAreaCode('adminhtml');

            $products = $this->_service->getProductPerCategory();

            $products = json_decode($products);

            foreach ($products->datos as $product) {
                $this->_createProduct->execute($product);
            }
        } catch (\Exception $e) {
            $this->logger->addInfo($e->getMessage());
            echo "Error: {$e->getMessage()} \n";
        }

    }
}

