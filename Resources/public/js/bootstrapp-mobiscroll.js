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

Bootstrapp.Mobiscroll = (function() {

    function Mobiscroll(input, options) {
        this.input = null;
        this.date = null;
        // options
        this.options = jQuery.extend({
            preset: 'date',
            animate: 'pop',
            delay: 300,
            display: 'inline',
            lang: 'en',
            mode: 'mixed', // scroller
            scrollLock: true,
            rows: 3,
            showLabel: true,
            theme: ''
        }, options);
        // callbacks
        this.onAnimStartCallbacks = [];
        this.onBeforeShowCallbacks = [];
        this.onCancelCallbacks = [];
        this.onChangeCallbacks = [];
        this.onCloseCallbacks = [];
        this.onSelectCallbacks = [];
        this.onShowCallbacks = [];
        this.setInput(input);
    }

    Mobiscroll.prototype.setInput = function(input) {
        // set element
        this.input = $(input);

        var instance = this,
            options = jQuery.extend(
                this.options, {
                showOnFocus:false,
                onAnimStart: function() {
                    instance.call(instance.onAnimStartCallbacks);
                },
                onBeforeShow: function() {
                    instance.call(instance.onBeforeShowCallbacks);
                },
                onCancel: function() {
                    instance.call(instance.onCancelCallbacks);
                },
                onChange: function() {
                    // new date selected, refresh date value
                    instance.date = null;
                    instance.getDate();
                    instance.call(instance.onChangeCallbacks);
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
                onShow: function() {
                    instance.call(instance.onShowCallbacks);
                }
            }
        );

        this.input.scroller(options);

        // hide inputs
        this.hide();
        this.input.css('visibility', "hidden");

        $(document).on('mousedown', function (e) {
            // Clicked outside the datepicker, hide it
            if ($(e.target).closest(instance.input.parent()).length == 0) {
                instance.hide();
            }
        });
    };

    Mobiscroll.prototype.getDate = function() {
        if(null == this.date) {
            this.date = this.input.scroller("getDate");
        }
        return this.date;
    };

    Mobiscroll.prototype.setDate = function(date) {
        if(date.getTime) {
            if(!this.getDate() || date.getTime() != this.date.getTime()) {
                this.input.scroller('setDate', date, true, 1);
                this.date = this.input.scroller("getDate");
            }
        }
        return this;
    };

    Mobiscroll.prototype.show = function() {
        if(this.input) {
            this.input.scroller("show");
        }
        return this;
    };

    Mobiscroll.prototype.hide = function() {
        if(this.input) {
            this.input.scroller("hide");
        }
        return this;
    };

    Mobiscroll.prototype.change = function(handler, context) {
        this.onChangeCallbacks.push({
            handler : handler,
            context : context
        });
        return this;
    };

    Mobiscroll.prototype.call = function(handlers) {
        $(handlers).each(function(index, handler) {
            if($.isFunction(handler)) {
                handler.call();
            } else if(handler && $.isFunction(handler.handler)) {
                var context = handler.context || null;
                handler = handler.handler;
                handler.call(context);
            }
        });
        return this;
    };

    return Mobiscroll;

})();
