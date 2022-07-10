var config = {
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Cento_CustomCheckoutField/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/view/shipping': {
                'Cento_CustomCheckoutField/js/view/shipping-mixin': true
            }
        }
    }
};
