/*!
 * bootstrapp-eyecon-datepicker.js v1.0.0
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if(typeof Bootstrapp == "undefined") {
    var Bootstrapp = {};
}

Bootstrapp.EyeconDatePicker = (function() {

    function EyeconDatePicker(input, options) {
        this.input = null;
        this.date = null;
        this.options = jQuery.extend({
            // eyecon
            format: 'yyyy-mm-dd',
            weekStart: 1,
            viewMode: 'days',
            minViewMode: 'days',
            // vitalets
            startDate: null,
            endDate: null,
            daysOfWeekDisabled: [0,6],
            autoclose: true,
            startView: 'days',
            todayBtn: 'linked',
            todayHighlight: true,
            keyboardNavigation: true,
            language: 'en',
            forceParse: false
        }, options);
        this.setInput(input);
    }

    EyeconDatePicker.prototype.getInput = function() {
        return this.input;
    };

    EyeconDatePicker.prototype.setInput = function(input) {
        // set element
        this.input = $(input);
        // initialize widget
        this.input.datepicker(this.options);
        return this;
    };

    EyeconDatePicker.prototype.getDate = function() {
        if(null == this.date) {
            var dates = this.input.val().split('-');
            this.date = new Date(dates[0], dates[1] - 1, dates[2], 0, 0, 0, 0);
        }
        return this.date;
    };

    EyeconDatePicker.prototype.setDate = function(date) {
        if(date.getTime) {
            date.setHours(0, 0, 0, 0);
            if(!this.getDate() || date.getTime() != this.date.getTime()) {
                this.date = null;
                // convert date to UTC because eyecon is using getUTC* methods
                date = new Date(Date.UTC(
                    date.getFullYear(),
                    date.getMonth(),
                    date.getDate(),
                    date.getHours(),
                    date.getMinutes(),
                    date.getSeconds(),
                    date.getMilliseconds()
                ));
                this.input.datepicker('update', date);
                this.getDate();
            }
        }
        return this;
    };

    EyeconDatePicker.prototype.show = function() {
        this.input.datepicker('show');
        return this;
    };

    EyeconDatePicker.prototype.hide = function() {
        this.input.datepicker('hide');
        return this;
    };

    EyeconDatePicker.prototype.change = function(handler, context) {
        this.input.datepicker().on('changeDate', {instance:this}, function(event){
            var instance = event.data.instance;
            instance.date = null;
            instance.getDate();
            handler.call(context);
        });
        return this;
    };

    return EyeconDatePicker;

})();
