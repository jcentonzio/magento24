<?php

namespace Cento\Automation\Cron;

use Cento\Automation\Helper\Service;
use Cento\Automation\Helper\AddOptionAttribute;
/**
 * Class ImportManufacturer
 *
 * @package \Cento\Automation\Cron
 */
class ImportManufacturer
{
    protected $_service;
    protected $_addOptionAttribute;
    /**
     * Constructor
     *
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        Service $service,
        AddOptionAttribute $addOptionAttribute
    )
    {
        $this->logger = $logger;
        $this->_service = $service;
        $this->_addOptionAttribute = $addOptionAttribute;
    }

    /**
     * Execute the cron
     *
     * @return void
     */
    public function execute()
    {
        $this->logger->addInfo("Cronjob ImportManufacturer is executed.");
        $manufacturerSource = $this->_service->getManufacturer();

        $manufacturerSource = json_decode($manufacturerSource);

        $manufacturers = [];

        foreach ($manufacturerSource->datos as $manufacturer) {
            $manufacturers[] = $manufacturer->descripcion;
        }

        $this->_addOptionAttribute->addOption($manufacturers);

    }




}
