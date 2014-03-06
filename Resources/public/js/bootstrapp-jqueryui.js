/*!
 * bootstrapp-pickadate.js v1.0.0
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if(typeof Bootstrapp == "undefined") {
    var Bootstrapp = {};
}

Bootstrapp.jQueryUIDatePicker = (function() {

    function jQueryUIDatePicker(input, options) {
        this.input = null;
        this.date = null;
        // options
        this.options = jQuery.extend({}, options);
        // callbacks
        this.onCloseCallbacks = [];
        this.onSelectCallbacks = [];
        this.onChangeMonthYearCallbacks = [];
        this.setInput(input);
    }

    jQueryUIDatePicker.prototype.setInput = function(input) {
        // set element
        this.input = $(input);

        var instance = this,
            options = jQuery.extend(
                this.options, {
                onClose: function() {
                    instance.call(instance.onCloseCallbacks);
                },
                onSelect: function() {
                    // new date selected, refresh date value
                    instance.date = null;
                    instance.getDate();
                    instance.call(instance.onSelectCallbacks);
                },
                onChangeMonthYear: function() {
                    instance.call(instance.onChangeMonthYearCallbacks);
                }
            }
        );

        this.input.datepicker(options);

        // hide inputs
        this.input.css('visibility', "hidden");
    };

    jQueryUIDatePicker.prototype.getDate = function() {
        if(null == this.date) {
            this.date = this.input.datepicker("getDate");
        }
        return this.date;
    };

    jQueryUIDatePicker.prototype.setDate = function(date) {
        if(date.getTime) {
            date.setHours(0, 0, 0, 0);
            if(!this.getDate() || !this.date.getTime || date.getTime() != this.date.getTime()) {
                this.date = null;
                this.input.datepicker("setDate", date);
                this.getDate();
            }
        }
        return this;
    };

    jQueryUIDatePicker.prototype.show = function() {
        if(this.input)
            this.input.datepicker("show");
        return this;
    };

    jQueryUIDatePicker.prototype.hide = function() {
        if(this.input)
            this.input.datepicker("hide");
        return this;
    };

    jQueryUIDatePicker.prototype.change = function(handler, context) {
        this.onSelectCallbacks.push({
            handler : handler,
            context : context
        });
        return this;
    };

    jQueryUIDatePicker.prototype.call = function(handlers) {
        $(handlers).each(function(index, handler) {
            if(jQuery.isFunction(handler)) {
                handler.call();
            } else if(jQuery.isFunction(handler.handler)) {
                var context = handler.context || null;
                handler = handler.handler;
                handler.call(context);
            }
        });
        return this;
    };

    return jQueryUIDatePicker;

})();
