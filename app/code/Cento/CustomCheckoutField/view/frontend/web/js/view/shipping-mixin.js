define(['jquery'], function($) {

    'use strict'

    return function(Component){
      return Component.extend({
          defaults: {
              tracks: {
                  typeClient: true,
                  regionID: true
              },
              listens: {
                  'checkoutProvider:shippingAddress.custom_attributes.type_client': 'handlerTypeClientChange',
                  'checkoutProvider:shippingAddress.region_id': 'handlerRegionIdChange'

              }
          },

          handlerTypeClientChange: function (newTypeClient) {

              if(newTypeClient === '2') {
                  $('[name="shippingAddress.custom_attributes.razon_social"]').css('display', 'list-item');
                  $('[name="shippingAddress.custom_attributes.rut_empresa"]').css('display', 'list-item');
                  $('[name="shippingAddress.custom_attributes.giro"]').css('display', 'list-item');
              }  else {
                  $('[name="shippingAddress.custom_attributes.razon_social"]').css('display', 'none');
                  $('[name="shippingAddress.custom_attributes.razon_social"]').removeClass('_required');
                  $('[name="shippingAddress.custom_attributes.rut_empresa"]').css('display', 'none');
                  $('[name="shippingAddress.custom_attributes.giro"]').css('display', 'none');
              }

              console.log("valor tipo de cliente: " + newTypeClient)
          },
          handlerRegionIdChange: function () {
              console.log("cambio region");
              $('[name="postcode"]').val('').change();
              $('[name="postcode"]').val('1234').change();
          }

      });
    };

});
