<?php

namespace Cento\Automation\Helper;

use Magento\Framework\Data\OptionSourceInterface;
use Magento\Eav\Model\Config;

/**
 * Class Options
 *
 * @package \Cento\Automation\Helper
 */
class Options implements OptionSourceInterface
{
    /**
     * @var Config
     */
    protected $_eavConfig;

    /**
     * @param Config $eavConfig
     */
    public function __construct(
        Config  $eavConfig
    )
    {
        $this->_eavConfig = $eavConfig;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray()
    {
        $coloOptions = $this->getManufacturerOption();
        return $coloOptions;
    }

    public function getManufacturerOption()
    {
        $attribute = $this->_eavConfig->getAttribute('catalog_product', 'manufacturer'); //color is product attribute.
        $options = $attribute->getSource()->getAllOptions();
        $optionsExists = array();
        /*foreach ($options as $option) {
            if ($option['value'] > 0) {
                $optionsExists[] = $option['label'];
            }
        }*/
        return $options;
    }

}
