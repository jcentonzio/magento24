/**
 * Webkul Software.
 *
 * @category  Webkul
 * @package   Webkul_RegionUpload
 * @author    Webkul
 * @copyright Copyright (c) Webkul Software Private Limited (https://webkul.com)
 * @license   https://store.webkul.com/license.html
 */
define(
    [
    "jquery",
    "Magento_Ui/js/modal/modal",
    'mage/translate',
    ], function ($,modal) {
        'use strict';
        $.widget(
            'mage.WkRegionUpload', {
                options: {

                },
                _create: function () {
                    var self = this;
                    var options = {
                        type: 'slide',
                        responsive: true,
                        innerScroll: true,
                        modalClass: 'popup', 
                        validation:{},
                        buttons: [
                            {
                                text: $.mage.__('Submit'),
                                class: 'action-primary',
                                click: function () {
                                    var form = $('#wk_regionupload_popup');
                                    $('#wk_regionupload_popup').submit();
                                }
                            }
                        ]
                    };
                    var popup = modal(options, $('#wk_regionupload_popup'));
                    $("#wk_upload_csv").click(function() {
                        $("wk_regionupload_popup").css('display','block')
                        $("#wk_regionupload_popup").modal("openModal");
                        
                    });
                    $("#wk_submit").click(function() {
                        $("#wk_region_add_form").submit();
                    });

                }
            }  
        )
        return $.mage.WkRegionUpload;
    }
);
