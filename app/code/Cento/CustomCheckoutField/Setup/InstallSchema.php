<?php
namespace Cento\CustomCheckoutField\Setup;

use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

class InstallSchema implements InstallSchemaInterface
{
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ){
        $setup->startSetup();

        $quote = $setup->getTable('quote_address');
        $salesOrder = $setup->getTable('sales_order_address');


        $setup->getConnection()->addColumn(
            $quote,
            'custom_test',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Custom test'
            ]
        );

        $setup->getConnection()->addColumn(
            $quote,
            'rut_empresa',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Rut empresa'
            ]
        );

        $setup->getConnection()->addColumn(
            $quote,
            'razon_social',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Razon social'
            ]
        );

        $setup->getConnection()->addColumn(
            $quote,
            'giro',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Giro'
            ]
        );


        $setup->getConnection()->addColumn(
            $salesOrder,
            'custom_test',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Custom test'
            ]
        );


        $setup->getConnection()->addColumn(
            $salesOrder,
            'rut_empresa',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Rut empresa'
            ]
        );

        $setup->getConnection()->addColumn(
            $salesOrder,
            'razon_social',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Razon social'
            ]
        );

        $setup->getConnection()->addColumn(
            $salesOrder,
            'giro',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
                'nullable' => true,
                'comment' =>'Giro'
            ]
        );


        $setup->endSetup();
    }
}
