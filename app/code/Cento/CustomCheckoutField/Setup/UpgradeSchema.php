<?php

namespace Cento\CustomCheckoutField\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{
    public function upgrade( SchemaSetupInterface $setup, ModuleContextInterface $context ) {

        $setup->startSetup();

        if(version_compare($context->getVersion(), '1.0.2', '<')) {

            $quote = $setup->getTable('quote_address');
            $salesOrder = $setup->getTable('sales_order_address');

            $setup->getConnection()->addColumn(
                $quote,
                'rut',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' =>'Rut'
                ]
            );


            $setup->getConnection()->addColumn(
                $salesOrder,
                'rut',
                [
                    'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                    'nullable' => true,
                    'comment' =>'Rut'
                ]
            );

        }

        $setup->endSetup();

    }
}
