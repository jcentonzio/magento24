<?php

namespace Cento\Automation\Helper;

/**
 * Class AddOptionAttribute
 *
 * @package \Cento\Automation\Helper
 */
class AddOptionAttribute
{
    protected $_eavSetupFactory;
    protected $_storeManager;
    protected $_attributeFactory;
    protected $_option;

    public function __construct(
        \Magento\Eav\Setup\EavSetupFactory $eavSetupFactory,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Catalog\Model\ResourceModel\Eav\Attribute $attributeFactory,
        \Cento\Automation\Helper\Options $options
    ) {
        $this->_eavSetupFactory = $eavSetupFactory;
        $this->_storeManager = $storeManager;
        $this->_attributeFactory = $attributeFactory;
        $this->_option = $options;
    }

    public function addOption($attribute_arr)
    {
        //$attribute_arr = ['Yellow','White','Black'];

        $attributeInfo= $this->_attributeFactory->getCollection()
            ->addFieldToFilter('attribute_code', ['eq'=>"manufacturer"])
            ->getFirstItem();
        $attribute_id = $attributeInfo->getAttributeId();

        $option=[];
        $option['attribute_id'] = $attributeInfo->getAttributeId();
        foreach ($attribute_arr as $key=>$value) {
            $option['value'][$value][0]=$value;
            $option['value'][$value][1] = $value;
        }

        $eavSetup = $this->_eavSetupFactory->create();
        $eavSetup->addAttributeOption($option);

        echo "agregado opciones a el atributo";
    }

    public function getManufacturerOptions()
    {
        return $this->_option->toOptionArray();
    }

    public function findManufacturerOption($manufacturer)
    {
        $options = $this->getManufacturerOptions();
        $key = array_search($manufacturer, array_column($options, 'label'));
        return $options[$key]['value'];
    }
}
