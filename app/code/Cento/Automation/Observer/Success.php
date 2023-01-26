<?php

namespace Cento\Automation\Observer;

class Success implements \Magento\Framework\Event\ObserverInterface
{
    protected $logger;

    public function __construct(
        \Psr\Log\LoggerInterface $logger
    )
    {
        $this->logger = $logger;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        $order = $observer->getEvent()->getOrder();
        $this->logger->error('Order Status'.$order->getState());
    }
}
