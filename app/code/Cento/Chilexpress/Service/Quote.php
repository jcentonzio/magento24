<?php

namespace Cento\Chilexpress\Service;


class Quote
{

    const URL_PROD = "https://services.wschilexpress.com/";
    const URL_TEST = "https://testservices.wschilexpress.com/";

    protected $_httpClientFactory;

    public function __construct(
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
    ) {
        $this->_httpClientFactory   = $httpClientFactory;
    }

    public function getCotizacion($comuna_origen, $comuna_destino, $weight, $height,$width, $length, $declaredWorth)
    {

        $payload = array(
            "originCountyCode" =>	$comuna_origen,
            "destinationCountyCode" => $comuna_destino,
            "package" => array(
                "weight" =>	"2",
                "height" =>	"10",
                "width" =>	"10",
                "length" =>	"10"
            ),
            "productType" => 3,
            "contentType" => 1,
            "declaredWorth" => $declaredWorth,
            "deliveryTime" => 0
        );

        $url = $this::URL_TEST.'rating/api/v1.0/rates/courier';
        $client = $this->_httpClientFactory->create();
        $client->setUri($url);
        $client->setConfig(['timeout' => 1000]);  // NOSONAR
        $client->setHeaders([
            "Ocp-Apim-Subscription-Key: 6ccbf66f195d43abac44eb607f7b019f",  // NOSONAR
            'Accept: application/json',  // NOSONAR
            'Content-Type: application/json'  // NOSONAR
        ]);
        $client->setMethod(\Zend_Http_Client::POST);
        $client->setRawData(json_encode($payload));

        try {
            $responseBody = $client->request()->getBody();
        } catch (\Exception $e) {
            return false;
        }

        return json_decode($responseBody);
    }

}
