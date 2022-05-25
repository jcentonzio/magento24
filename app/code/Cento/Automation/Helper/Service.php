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
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getManufacturer() {

        try {

            $client = new Client();

            $response = $client->get('http://45.182.116.158:5030/busa/marcas');

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
                    "categoria" => "4"
                ]
            ];

            $response = $client->post('http://45.182.116.158:5030/busa/filtroproducto', [
                'json' => $params
            ]);

            if ($response->getStatusCode() !== 200) {
                throw new \InvalidArgumentException('There was a problem: ' . $response->getBody());
            }

            return (string)$response->getBody();

        } catch (\Exception $ex) {
            $this->logger->critical($ex->getMessage());
            throw $ex;
        }
    }
}
