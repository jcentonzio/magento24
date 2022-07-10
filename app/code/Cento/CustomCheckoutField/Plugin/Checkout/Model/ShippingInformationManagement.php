<?php
namespace Cento\CustomCheckoutField\Plugin\Checkout\Model;


class ShippingInformationManagement
{
    protected $quoteRepository;

    protected $dataHelper;

    public function __construct(
        \Magento\Quote\Model\QuoteRepository $quoteRepository
    )
    {
        $this->quoteRepository = $quoteRepository;
    }

    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        \Magento\Checkout\Api\Data\ShippingInformationInterface $addressInformation
    )
    {
        $shippingAddress = $addressInformation->getShippingAddress();
        $shippingExtensionAttributes = $shippingAddress->getExtensionAttributes();

        if(!empty($shippingExtensionAttributes)) {
            $shippingExtensionAttributes = $shippingAddress->getExtensionAttributes();
            if(!empty($shippingExtensionAttributes)) {

                $writer = new \Zend\Log\Writer\Stream(BP . '/var/log/test.log');
                $logger = new \Zend\Log\Logger();
                $logger->addWriter($writer);
                $logger->info('rut: '.print_r($shippingExtensionAttributes->getRutEmpresa(), true));

                $shippingAddress
                    ->setRutEmpresa($shippingExtensionAttributes->getRutEmpresa())
                    ->setRazonSocial($shippingExtensionAttributes->getRazonSocial())
                    ->setGiro($shippingExtensionAttributes->getGiro());
            }
        }

    }
}
