<?php

namespace Cento\Chilexpress\Setup;

use Magento\Framework\DB\Ddl\Table;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\UpgradeSchemaInterface;


class UpgradeSchema implements UpgradeSchemaInterface
{
    /**
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $connection = $installer->getConnection();
        $tableName  = $setup->getTable('directory_country_region');
        if (version_compare($context->getVersion(), '1.1.0', '<')

        ) {
            $connection->addColumn(
                $tableName,
                'code_chilexpress',
                [
                    'type'    => Table::TYPE_TEXT,
                    'comment' => 'codigo Chile Express',
                ]
            );
        }

        $installer->endSetup();
    }
}
