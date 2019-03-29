define([
    'uiComponent',
    'Magento_Customer/js/customer-data'
], function (Component, customerData) {
    'use strict';

    return Component.extend({
        /** @inheritdoc */
        initialize: function () {
            this._super();

            this.fields = customerData.get('pc-customer-data');
        },
        getValue: function(key) {
            return key.split(".").reduce(function(o, x) {
                return (typeof o == "undefined" || o === null || typeof o[x] == "undefined" || o[x] == null) ? '' : o[x];
            }, this.fields());
        }
    });
});
