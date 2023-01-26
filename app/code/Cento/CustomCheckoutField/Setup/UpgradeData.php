<?php

namespace Cento\CustomCheckoutField\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;

use Magento\Customer\Model\Customer;
use Magento\Customer\Setup\CustomerSetupFactory;
use Magento\Eav\Model\Entity\Attribute\Set as AttributeSet;
use Magento\Eav\Model\Entity\Attribute\SetFactory as AttributeSetFactory;

class UpgradeData implements UpgradeDataInterface
{

    private $customerSetupFactory;

    /**
     * @var AttributeSetFactory
     */
    private $attributesetFactory;

    /**
     * Constructor
     *
     * @param \Magento\Customer\Setup\CustomerSetupFactory $customerSetupFactory
     */

    public function __construct(
        CustomerSetupFactory $customerSetupFactory,
        AttributeSetFactory $attributesetFactory
    ) {
        $this->customerSetupFactory = $customerSetupFactory;
        $this->attributesetFactory = $attributesetFactory;
    }

    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        if (version_compare($context->getVersion(), '1.0.1', '<'))
        {
          $this->addAttributeAddress($setup);
        }
    }



    protected function addAttributeAddress(ModuleDataSetupInterface $setup){
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);

        $customerEntity = $customerSetup->getEavConfig()->getEntityType('customer');
        $attributeSetId = $customerEntity->getDefaultAttributeSetId();
        $attributeSet = $this->attributesetFactory->create();
        $attributeGroupId = $attributeSet->getDefaultGroupId($attributeSetId);


        $customerSetup->addAttribute('customer_address', 'rut', [
            'label' => 'Rut',
            'input' => 'text',
            'type' => 'varchar',
            'source' => '',
            'required' => false,
            'position' => 333,
            'visible' => false,
            'system' => false,
            'is_used_in_grid' => false,
            'is_visible_in_grid' => false,
            'is_filterable_in_grid' => false,
            'is_searchable_in_grid' => false,
            'backend' => ''
        ]);

        $attribute=$customerSetup->getEavConfig()
            ->getAttribute('customer_address','rut')
            ->addData([
                'attribute_set_id' => $attributeSetId,
                'attribute_group_id' => $attributeGroupId,
                'used_in_forms' => [
                    'adminhtml_customer_address',
                    'adminhtml_customer',
                    'customer_address_edit',
                    'customer_register_address',
                    'customer_address'
                ]
            ]);

        $attribute->save();

    }


}
