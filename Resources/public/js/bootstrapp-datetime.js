/*!
 * bootstrapp-datetime.js v1.0.0
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if(typeof Bootstrapp == "undefined") {
    var Bootstrapp = {};
}

Bootstrapp.DateTime = (function() {

    function DateTime(element, options, pluginGetter) {
        element = $(element);
        var parent = element.parent(),
            widget = parent.data('widget'),
            type = parent.data('type'),
            grandparent = parent.parent(),
            grandwidget = grandparent.data('widget'),
            grandtype = grandparent.data('type');

        this.element = element;
        this.plugin = null;
        this.date = null;
        this.format = {"format": "date", "type": "long"};
        $this = this;
        this.fmt = new TwitterCldr.DateTimeFormatter();

        // format
        var formatKey = '',
            formatValue = this.element.data('format'),
            formatToken = [];
        if(formatValue) {
            switch(formatValue) {
                case 'short':
                    break;
                case 'medium':
                    break;
                case 'long':
                    break;
                case 'full':
                    break;
                default:
                    // add additionnal format
                    $(formatValue.split(/([\s\/\-\.\,\_\:]+)/g)).each(function(index, part) {
                        if(/[\s\/\-\.\,\_\:]+/.test(part)) {
                            formatToken.push({
                                value: part,
                                type: "plaintext"
                            });
                        } else {
                            formatToken.push({
                                value: part,
                                type: "pattern"
                            });
                            formatKey += part;
                        }
                    });
                    if(!this.fmt.tokens["date_time"]["additional"][formatKey]) {
                        this.fmt.tokens["date_time"]["additional"][formatKey] = formatToken;
                    }
                    this.format = {"format": "additional", "type": formatKey};
                    break;
            }
        } else {
            this.format = {"format": "date_time", "type": "long"};
        }

        // plugin
        if(grandparent && 'datetime' == grandtype && widget == grandwidget) {
            parent = grandparent;
        }
        if(!(this.plugin = parent.data('plugin')) && typeof pluginGetter == 'function') {
            this.plugin = pluginGetter(element);
            parent.data('plugin', this.plugin);
        }

        // events
        this.element.on({
            change: $.proxy(this.onChange, this),
            focus: $.proxy(this.onFocus, this),
            keydown: $.proxy(this.onKeyDown, this)
        });
        this.element.parent().click({instance:this}, function(event) {
            event.data.instance.onClick(event);
        });

        if(this.plugin) {
            //var self = this;
            //this.plugin.change(function(){
            //    self.onPluginChange();
            //});
            this.plugin.change(this.onPluginChange, this);
        }

        this.element.change();
    }

    DateTime.prototype.getElement = function() {
        return this.element;
    }

    DateTime.prototype.onChange = function(event) {
        try {
            var date = this.fmt.parse(this.element.val(), this.format);
            if(this.plugin)
                this.plugin.setDate(date);
            this.setDate(date);
            this.element.removeClass('error');
            this.element.tooltip('destroy');
        } catch(e) {
            this.element.addClass('error');
            this.element.tooltip({
                title : "Please check the date",
                placement: 'right',
                trigger: 'manual'
            });
            this.element.tooltip('show');
        }
    }

    DateTime.prototype.onFocus = function(event) {
        this.show();
    }

    DateTime.prototype.onKeyDown = function(event) {
        switch(event.keyCode){
            case 27: // escape
                this.hide();
                event.preventDefault();
                break;
            //case 13: // enter
            //    this.show();
            //    event.preventDefault();
            //    break;
            case 9: // tab
                this.hide();
                break;
        }
    }

    DateTime.prototype.onClick = function(event) {
        this.show();
    }

    DateTime.prototype.onPluginChange = function() {
        if(this.plugin)
            this.setDate(this.plugin.getDate());
    }

    DateTime.prototype.setDate = function(date) {
        this.date = date;
        this.element.val(this.fmt.format(this.date, this.format));
    }

    DateTime.prototype.show = function() {
        if(this.plugin) {
            this.plugin.show();
            var plugin = this.plugin;
            setTimeout(function(){plugin.show();}, 0);
        }
    }

    DateTime.prototype.hide = function() {
        if(this.plugin) {
            var plugin = this.plugin;
            setTimeout(function(){plugin.hide();}, 0);
        }
    }

    return DateTime;
})();

$.fn.datetime = function(options, pluginGetter) {
    return this.each(function () {
        var $this = $(this),
            data = $this.data('bootstrapp'),
            options = {} || options;
        if (!data) {
            $this.data('bootstrapp',new Bootstrapp.DateTime(this, options, pluginGetter));
        }
    });
};