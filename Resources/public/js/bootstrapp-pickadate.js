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

Bootstrapp.Pickadate = (function() {

    function Pickadate(input, options) {
        this.input = null;
        this.calendar = null;
        this.date = null;
        // options
        this.options = jQuery.extend({
            // Display strings
            showMonthsShort: false,
            showWeekdaysFull: false,
            // Date format
            format: 'yyyy-mm-dd',
            formatSubmit: false,
            hiddenSuffix: '_submit',
            // First day of the week
            firstDay: 1,
            // Dropdown selectors
            selectYears: true,
            selectMonths: true,
            // Date ranges
            min: false,
            max: false,
            // Dates disabled
            disable: false // [true]
        }, options);
        // callbacks
        this.onStartCallbacks = [];
        this.onOpenCallbacks = [];
        this.onCloseCallbacks = [];
        this.onSelectCallbacks = [];
        this.onChangeMonthCallbacks = [];
        this.setInput(input);
    }

    Pickadate.prototype.setInput = function(input) {
        // set element
        this.input = $(input);

        var instance = this;
        var options = jQuery.extend(
            this.options, {
                onStart: function() {
                    instance.call(instance.onStartCallbacks);
                },
                onOpen: function() {
                    instance.call(instance.onOpenCallbacks);
                },
                onClose: function() {
                    instance.call(instance.onCloseCallbacks);
                },
                onSet: function() {
                    // new date selected, refresh date value
                    instance.date = null;
                    instance.getDate();
                    instance.call(instance.onSelectCallbacks);
                },
                onRender: function() {
                    instance.call(instance.onChangeMonthCallbacks);
                }
            }
        );
        this.input.pickadate(this.options);

        // hide inputs
        this.input.css('visibility', "hidden");
        this.input.css('display', "none");

        // get calendar object
        this.calendar = this.input.data('pickadate');
    };

    Pickadate.prototype.getDate = function() {
        if(null == this.date) {
            this.date = this.calendar.get('select').obj;
        }
        return this.date;
    };

    Pickadate.prototype.setDate = function(date) {
        if(date.getTime) {
            date.setHours(0, 0, 0, 0);
            if(!this.getDate() || date.getTime() != this.date.getTime()) {
                this.date = null;
                this.calendar.set('select', date);
                this.getDate();
            }
        }
        return this;
    };

    Pickadate.prototype.show = function() {
        if(this.calendar)
            this.calendar.open();
        return this;
    };

    Pickadate.prototype.hide = function() {
        if(this.calendar)
            this.calendar.close();
        return this;
    };

    Pickadate.prototype.change = function(handler, context) {
        this.onSelectCallbacks.push({
            handler : handler,
            context : context
        });
        return this;
    };

    Pickadate.prototype.call = function(handlers) {
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

    return Pickadate;

})();
