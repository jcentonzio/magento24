<?php

namespace Cento\Automation\Helper;

/**
 * Class Service
 *
 * @package \Cento\Automation\Helper
 */

use GuzzleHttp\Client;
use Psr\Log\LoggerInterface;

class Service
{
    protected $scopeConfig;

    public function __construct(
        LoggerInterface $logger,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig
    )
    {
        $this->logger = $logger;
        $this->scopeConfig = $scopeConfig;
    }

    public function getManufacturer() {

        try {

            $client = new Client();

            // http://161.35.232.26:5030/busa/marcas
            $response = $client->get($this->scopeConfig->getValue('cento/cento/manufacturer'));

            if ($response->getStatusCode() !== 200) {
                throw new \InvalidArgumentException('There was a problem: ' . $response->getBody());
            }

            return (string)$response->getBody();

        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage());
            throw $ex;
        }
    }

    public function getProductPerCategory() {
        try {

            $client = new Client();

            $params = [
                "data" => [
                    "categoria" => $this->scopeConfig->getValue('cento/cento/category_id')
                ]
            ];

            // http://161.35.232.26:5030/busa/filtroproducto

            $response = $client->post($this->scopeConfig->getValue('cento/cento/product_category'), ["json" => $params]);

            if ($response->getStatusCode() !== 200) {
                throw new \InvalidArgumentException('There was a problem: ' . $response->getBody());
            }

            return (string)$response->getBody();

        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage());
            throw $ex;
        }
    }

    public function updateProduct($sku) {
        try {

            $client = new Client();

            $params = [
                "data" => [
                    "codigo" => $sku
                ]
            ];

            $response = $client->post($this->scopeConfig->getValue('cento/cento/product'),  ["json" => $params, 'timeout' => 20,
                'connect_timeout' => 10]);

            return (string)$response->getBody();

        } catch (\Exception $ex) {
            echo "{$ex->getMessage()} \n";
            $this->logger->critical($ex->getMessage());
        }
    }


}
