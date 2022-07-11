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

        $result['telephone']['config'] = [
            'template' => 'ui/form/field',
            'elementTmpl' => 'ui/form/element/input',
            'placeholder' => 'Ej: 987654321 (9 dígitos)',
            'tooltip' => ''
        ];


        $result['telephone']['validation'] = [
            'required-entry'  => true,
            'max_text_length' => 9,
            'validate-number' => true
        ];


        return $result;
    }
}
