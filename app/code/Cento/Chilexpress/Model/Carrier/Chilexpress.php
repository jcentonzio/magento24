<?php
/**
 * Copyright ©  All rights reserved.
 * See COPYING.txt for license details.
 */
declare(strict_types=1);

namespace Cento\Chilexpress\Model\Carrier;

use Magento\Quote\Model\Quote\Address\RateRequest;
use Magento\Shipping\Model\Rate\Result;
use Cento\Chilexpress\Service\Quote;
use Magento\Directory\Model\RegionFactory;

class Chilexpress extends \Magento\Shipping\Model\Carrier\AbstractCarrier implements
    \Magento\Shipping\Model\Carrier\CarrierInterface
{
    const DEFAULT_VOL = 5;

    protected $_code = 'chilexpress';

    protected $_isFixed = true;

    protected $_rateResultFactory;

    protected $_rateMethodFactory;

    protected $_quote;

    protected $_cart;

    protected $productFactory;

    protected $regionFactory;




    /**
     * Constructor
     *
     * @param \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
     * @param \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory
     * @param \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Quote\Model\Quote\Address\RateResult\ErrorFactory $rateErrorFactory,
        \Psr\Log\LoggerInterface $logger,
        \Magento\Shipping\Model\Rate\ResultFactory $rateResultFactory,
        \Magento\Quote\Model\Quote\Address\RateResult\MethodFactory $rateMethodFactory,
        Quote $quote,
        \Magento\Checkout\Model\Cart $cartModel,
        \Magento\Catalog\Model\ProductFactory $productFactory,
        RegionFactory $regionFactory,
        array $data = []
    ) {
        $this->_rateResultFactory = $rateResultFactory;
        $this->_rateMethodFactory = $rateMethodFactory;
        $this->_quote = $quote;
        $this->_cart = $cartModel;
        $this->productFactory = $productFactory;
        $this->regionFactory = $regionFactory;
        parent::__construct($scopeConfig, $rateErrorFactory, $logger, $data);
    }

    /**
     * {@inheritdoc}
     */
    public function collectRates(RateRequest $request)
    {

        if (!$this->getConfigFlag('active')) {
            return false;
        }

        $shippingPrice = false;

        $items = $this->_cart->getQuote()->getAllItems();


        $region = $this->regionFactory->create()->load($request->getDestRegionId());
        $codeDest = $region->getData('code_chilexpress');

        $this->_logger->info("REGION:". $request->getDestRegionCode());

        $height = 0;
        $width = 0;
        $length = 0;

        foreach($items as $item) {
            $product = $this->productFactory->create()->load($item->getProductId());

            if(!empty($product->getHigh())) {
                $height += ($product->getHigh() * $item->getQty());
            } else {
                $height += (self::DEFAULT_VOL * $item->getQty());
            }

            if(!empty($product->getWidth())) {
                $width += ($product->getWidth() * $item->getQty());
            } else {
                $width += (self::DEFAULT_VOL * $item->getQty());
            }

            if(!empty($product->getLong())) {
                $length += ($product->getLong() * $item->getQty());
            } else {
                $length += (self::DEFAULT_VOL * $item->getQty());
            }

        }

        $comuna_origen = 'STGO';
        $comuna_destino = $codeDest;
        $weight = $request->getPackageWeight();
        $declaredWorth = '5000';

        if($comuna_destino) {
            $courrierservices = $this->_quote->getCotizacion($comuna_origen,$comuna_destino,$weight,$height,$width,$length,$declaredWorth);
            foreach ($courrierservices->data->courierServiceOptions as $item) {
                if($item->serviceTypeCode == 3) {
                    $shippingPrice = $item->serviceValue;
                }
            }
        }

        $this->_logger->info("PRECIO:". $shippingPrice);

        $result = $this->_rateResultFactory->create();

        if ($shippingPrice !== false) {
            $method = $this->_rateMethodFactory->create();

            $method->setCarrier($this->_code);
            $method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod($this->_code);
            $method->setMethodTitle($this->getConfigData('name'));

            if ($request->getFreeShipping() === true) {
                $shippingPrice = '0.00';
            }

            $method->setPrice($shippingPrice);
            $method->setCost( $shippingPrice);

            $result->append($method);
        }


        return $result;
    }

    /**
     * getAllowedMethods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return [$this->_code => $this->getConfigData('name')];
    }
}
