<?php

namespace Cento\CustomCheckoutField\Plugin\Checkout\Block\Checkout;

use Magento\Checkout\Block\Checkout\AttributeMerger;

class PhonePlugin
{
    /**
     * @param AttributeMerger $subject
     * @param $result
     * @return mixed
     */
    public function afterMerge(AttributeMerger $subject, $result)
    {
        $result['telephone']['validation'] = [
            'required-entry'  => true,
            'max_text_length' => 9,
            'validate-number' => true
        ];

        $result['telephone']['config'] = [
            'customScope' => 'shippingAddress.custom_attributes',
            'customEntry' => null,
            'template' => 'ui/form/field',
            'elementTmpl' => 'ui/form/element/input',
            'placeholder' => 'Ej: 987654321 (9 dígitos)',
            'tooltip' => false
        ];

        return $result;
    }
}
