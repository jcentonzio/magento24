<?php
namespace Cento\CustomCheckoutField\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class CheckoutSubmitAllAfterObserver implements ObserverInterface
{
    public function execute(\Magento\Framework\Event\Observer $observer)
    {

        $order = $observer->getEvent()->getOrder();

        $quote = $observer->getEvent()->getQuote();


        if(empty($order) || empty($quote)){
            return $this;
        }

        $shippingAddress = $quote->getShippingAddress();

        $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
        $logger = new \Zend\Log\Logger();
        $logger->addWriter($writer);
        $logger->info('Empresa: '.print_r($shippingAddress->getRutEmpresa(), true));


        if($shippingAddress->getRutEmpresa()) {

            $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
            $logger = new \Zend\Log\Logger();
            $logger->addWriter($writer);
            $logger->info('tiene rut: '.print_r($shippingAddress->getRutEmpresa(), true));

            $objectManager = \Magento\Framework\App\ObjectManager::getInstance();

            $orderShippingAddress = $order->getShippingAddress();
            $orderShippingAddress
                ->setRutEmpresa($shippingAddress->getRutEmpresa())
                ->setRazonSocial($shippingAddress->getRazonSocial())
                ->setGiro($shippingAddress->getGiro())
                ->save();

            if($shippingAddress->getCustomerAddressId()) {

                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
                $logger = new \Zend\Log\Logger();
                $logger->addWriter($writer);
                $logger->info('tiene direccion: '.print_r($shippingAddress->getRutEmpresa(), true));


                $address = $objectManager->create('Magento\Customer\Model\Address')->load($shippingAddress->getCustomerAddressId());
                $address
                    ->setRutEmpresa($shippingAddress->getRutEmpresa())
                    ->setRazonSocial($shippingAddress->getRazonSocial())
                    ->setGiro($shippingAddress->getGiro())
                    ->save();
            }

        }

        return $this;
    }
}
