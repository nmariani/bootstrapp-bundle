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

Bootstrapp.JdewitTimepicker = (function() {

    function JdewitTimepicker(input, options) {
        this.input = null;
        this.timepicker = null;
        this.date = null;
        this.options = jQuery.extend({
            template:     'dropdown',
            minuteStep:   1,
            showSeconds:  false,
            secondStep:   1,
            defaultTime:  'value',
            showMeridian: false,
            showInput:   true,
            disableFocus: false,
            modalBackdrop: false
        }, options);
        this.setInput(input);
    }

    JdewitTimepicker.prototype.getInput = function() {
        return this.input;
    };

    JdewitTimepicker.prototype.setInput = function(input) {
        // set element
        this.input = $(input);
        // initialize widget
        this.input.timepicker(this.options);
        this.timepicker = this.input.data('timepicker');
        return this;
    };

    JdewitTimepicker.prototype.getDate = function() {
        if((null == this.date) && this.timepicker) {
            this.date = new Date();
            this.date.setHours(
                isNaN(this.timepicker.hour) ? 0 : this.timepicker.hour,
                isNaN(this.timepicker.minute) ? 0 : this.timepicker.minute,
                isNaN(this.timepicker.second) ? 0 : this.timepicker.second,
                0
            );
        }
        return this.date;
    };

    JdewitTimepicker.prototype.setDate = function(date) {
        if(date.getTime) {
            if(!this.getDate() || date.getTime() != this.date.getTime()) {
                this.date = null;
                this.timepicker.setTime(date.getHours()+':'+date.getMinutes()+':'+date.getSeconds());
                this.getDate();
            }
        }
        return this;
    };

    JdewitTimepicker.prototype.show = function() {
        var e = jQuery.Event("click");
        //this.input.trigger( e );
        this.timepicker.showWidget(e);
        return this;
    };

    JdewitTimepicker.prototype.hide = function() {
        this.timepicker.hideWidget();
        return this;
    };

    JdewitTimepicker.prototype.change = function(handler, context) {
        this.input.change({instance:this}, function(event){
            var instance = event.data.instance;
            instance.date = null;
            instance.getDate();
            handler.call(context);
        });
        return this;
    };

    return JdewitTimepicker;

})();
