<?php
namespace Dev\Testing\Plugin\Checkout\Block\Checkout;
class LayoutProcessor
{
    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_notes'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'custom-notes'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.custom_notes',
            'label' => 'Factura',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 299,
            'id' => 'custom-notes',
            'options' => [
                [
                    'value' => '',
                    'label' => 'Seleccione',
                ],
                [
                    'value' => '1',
                    'label' => 'Empresa',
                ],
                [
                    'value' => '2',
                    'label' => 'Persona',
                ]
            ]
        ];

        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']
        ['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_empresa'] = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select',
                'id' => 'custom-empresa'
            ],
            'dataScope' => 'shippingAddress.custom_attributes.custom_empresa',
            'label' => 'empresa',
            'provider' => 'checkoutProvider',
            'visible' => true,
            'validation' => [],
            'sortOrder' => 299,
            'id' => 'custom-empresa'
        ];


        return $jsLayout;
    }
}
