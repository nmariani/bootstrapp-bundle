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
            // Strings
            monthsFull: [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
            monthsShort: [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ],
            weekdaysFull: [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ],
            weekdaysShort: [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
            monthPrev: '&#9664;',
            monthNext: '&#9654;',
            // Display strings
            showMonthsFull: true,
            showWeekdaysShort: true,
            // Date format
            //format: 'd mmmm, yyyy',
            format: 'yyyy-mm-dd',
            formatSubmit: false,
            hiddenSuffix: '_submit',
            // First day of week
            firstDay: 0,
            // Month & year dropdown selectors
            monthSelector: false,
            yearSelector: false,
            // Date ranges
            dateMin: false,
            dateMax: false,
            // Dates disabled
            datesDisabled: false,
            // Disable picker
            disablePicker: false
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
                onSelect: function() {
                    // new date selected, refresh date value
                    instance.date = null;
                    instance.getDate();
                    instance.call(instance.onSelectCallbacks);
                },
                onChangeMonth: function() {
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
            var dates = this.calendar.getDate().split('-');
            this.date = new Date(dates[0], dates[1] - 1, dates[2], 0, 0, 0, 0);
        }
        return this.date;
    };

    Pickadate.prototype.setDate = function(date) {
        if(date.getTime) {
            date.setHours(0, 0, 0, 0);
            if(!this.getDate() || date.getTime() != this.date.getTime()) {
                this.date = null;
                this.calendar.setDate(date.getFullYear(), date.getMonth()+1, date.getDate());
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
