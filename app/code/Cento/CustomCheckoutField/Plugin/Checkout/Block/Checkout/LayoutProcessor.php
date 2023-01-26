<?php
namespace Cento\CustomCheckoutField\Plugin\Checkout\Block\Checkout;
class LayoutProcessor
{
    protected $customerSession;

    public function __construct(
        \Magento\Customer\Model\Session $customerSession
    )
    {
        $this->customerSession = $customerSession;
    }

    public function afterProcess(
        \Magento\Checkout\Block\Checkout\LayoutProcessor $subject,
        array  $jsLayout
    ) {



        if($this->customerSession->getCustomer()->getId()) {
            $login = true;
        } else {
            $login = false;
        }

        $rut = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'rut',
            'label' => 'Rut',
            'provider' => 'checkoutProvider',
            'sortOrder' => 0,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'value' => ''
        ];

        $typeClient = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'type_client',
            'label' => 'Tipo de cliente',
            'provider' => 'checkoutProvider',
            'sortOrder' => 200,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [
                [
                    'value' => '',
                    'label' => 'Seleccione',
                ],
                [
                    'value' => '1',
                    'label' => 'Persona',
                ],
                [
                    'value' => '2',
                    'label' => 'Empresa',
                ]
            ],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'value' => ''
        ];


        $razonSocial = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'razon_social',
            'label' => 'Razón social',
            'provider' => 'checkoutProvider',
            'sortOrder' => 201,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => ''
        ];

        $rutEmpresa = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'rut_empresa',
            'label' => 'Rut empresa',
            'provider' => 'checkoutProvider',
            'sortOrder' => 202,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => ''
        ];

        $giroEmpresa = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input',
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'giro',
            'label' => 'Giro',
            'provider' => 'checkoutProvider',
            'sortOrder' => 203,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => ''
        ];

        $customTest = [
            'component' => 'Magento_Ui/js/form/element/abstract',
            'config' => [
                // customScope is used to group elements within a single form (e.g. they can be validated separately)
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/input'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'custom_test',
            'label' => 'Custom test',
            'provider' => 'checkoutProvider',
            'sortOrder' => 204,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => false,
            'value' => ''
        ];

        $seller = [
            'component' => 'Magento_Ui/js/form/element/select',
            'config' => [
                'customScope' => 'shippingAddress.custom_attributes',
                'customEntry' => null,
                'template' => 'ui/form/field',
                'elementTmpl' => 'ui/form/element/select'
            ],
            'dataScope' => 'shippingAddress.custom_attributes' . '.' . 'seller',
            'label' => 'Vendedor',
            'provider' => 'checkoutProvider',
            'sortOrder' => 500,
            'validation' => [
                'required-entry' => true
            ],
            'options' => [
                [
                    'value' => '',
                    'label' => 'Seleccione',
                ],
                [
                    'value' => '25',
                    'label' => 'CALDERON MENDOZA PAUL RICHARD',
                ],
                [
                    'value' => '54',
                    'label' => 'MEDEL ULLOA CLAUDIO',
                ],
                [
                    'value' => '84',
                    'label' => 'QUINTANA RODRIGUEZ JORMAN',
                ]
            ],
            'filterBy' => null,
            'customEntry' => null,
            'visible' => true,
            'value' => ''
        ];


        $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['rut'] = $rut;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['type_client'] = $typeClient;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['razon_social'] = $razonSocial;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['rut_empresa'] = $rutEmpresa;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['giro'] = $giroEmpresa;
       $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['custom_test'] = $customTest;
       if($login) {
           $jsLayout['components']['checkout']['children']['steps']['children']['shipping-step']['children']['shippingAddress']['children']['shipping-address-fieldset']['children']['seller'] = $seller;
       }

       return $jsLayout;

    }
}
