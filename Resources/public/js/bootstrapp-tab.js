/*!
 * bootstrapp-tab.js v1.0.0
 *
 * Copyright (c) 2012-2014, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
+function ($) {
    'use strict';

    // TAB CLASS DEFINITION
    // ====================

    var BootstrappTab = function (element) {
        this.element = $(element);
        this.wrapper = this.element.parent();
        if (this.wrapper.length == 0 || !this.wrapper.is('.nav-tabs-wrapper')) {
            this.wrapper = $('<div class="nav-tabs-wrapper"></div>');
            this.element.before(this.wrapper);
            this.wrapper.append(this.element);
        }
        this.refresh();
        this.getButtonPrev().click($.proxy(function(){this.prev();}, this));
        this.getButtonNext().click($.proxy(function(){this.next();}, this));
    }

    BootstrappTab.prototype.getMaxScrollLeft = function () {
        return this.element.get(0).scrollWidth - this.element.width();
    }

    BootstrappTab.prototype.getTabs = function () {
        return this.element.children();
    }

    BootstrappTab.prototype.getButtons = function () {
        var buttons = this.wrapper.children().filter('button');
        if (buttons.length == 0) {
            this.wrapper.prepend(
                '<button type="button" class="btn btn-link" data-scroll="prev">' +
                    '<i class="icon-chevron-left"></i>' +
                '</button>'
            );
            this.wrapper.append(
                '<button type="button" class="btn btn-link" data-scroll="next">' +
                    '<i class="icon-chevron-right"></i>' +
                '</button>'
            );
            buttons = this.wrapper.children().filter('button');
        }
        return buttons;
    }

    BootstrappTab.prototype.getButtonPrev = function () {
        return this.getButtons().filter('button[data-scroll=prev]');
    }

    BootstrappTab.prototype.getButtonNext = function () {
        return this.getButtons().filter('button[data-scroll=next]');
    }

    BootstrappTab.prototype.refresh = function () {
        if (this.element.scrollLeft() == 0) {
            this.toggleButtonPrev(false);
        } else {
            this.toggleButtonPrev(true);
        }
        var last = this.getTabs().last();
        if (last.position().left + last.width() > this.element.width()) {
            this.toggleButtonNext(true);
        } else {
            this.toggleButtonNext(false);
        }
    }

    BootstrappTab.prototype.prev = function () {
        if (!this.getMaxScrollLeft()) {
            return;
        }
        this.toggleButtonNext(true);
        if ((this.element.scrollLeft() - this.element.width()) <= 0) {
            this.scrollTo(0);
        } else {
            this.getTabs().each($.proxy(function(index, tab){
                tab = $(tab);
                if (tab.position().left >= -this.element.width()) {
                    this.scrollTo(this.element.scrollLeft() + tab.prev().position().left);
                    return false;
                }
            }, this));
        }
    }

    BootstrappTab.prototype.next = function () {
        if (!this.getMaxScrollLeft()) {
            return;
        }
        this.toggleButtonPrev(true);
        var scrollLeft = this.element.scrollLeft() + this.element.width(),
            maxScrollLeft = this.getMaxScrollLeft();
        if (scrollLeft >= maxScrollLeft) {
            this.scrollTo(maxScrollLeft);
        } else {
            this.getTabs().each($.proxy(function(index, tab){
                tab = $(tab);
                if (tab.is(':last-child')) {
                    this.scrollTo(maxScrollLeft);
                } else if (this.element.scrollLeft() + tab.position().left + tab.width() > scrollLeft) {
                    this.scrollTo(this.element.scrollLeft() + tab.position().left);
                    return false;
                }
            }, this));
        }
    }

    BootstrappTab.prototype.scrollTo = function (to) {
        var scrollLeft = null;
        if ($.isNumeric(to)) {
            scrollLeft = to;
        } else {
            to = $(to);
            if (to.length == 0) {
                return;
            }
            if (to.is(':first-child')) {
                scrollLeft = 0;
            } else if (to.is(':last-child')) {
                scrollLeft = this.getMaxScrollLeft();
            } else {
                if (to.position().left < 0) {
                    scrollLeft = this.element.scrollLeft() + to.position().left;
                } else if (to.position().left > 0) {
                    scrollLeft = this.element.scrollLeft() + to.position().left + to.width();
                }
            }
        }
        if (scrollLeft == 0) {
            this.toggleButtonPrev(false);
        } else if (scrollLeft == this.getMaxScrollLeft()) {
            scrollLeft = this.getMaxScrollLeft() + this.getButtonNext().width();
            this.toggleButtonNext(false);
        }
        if (this.element.scrollLeft() != scrollLeft) {
            this.element.animate({
                scrollLeft: scrollLeft
            }, {
                complete: $.proxy(function() {
                    this.refresh();
                }, this)
            });
        } else {
            this.refresh();
        }
    }

    BootstrappTab.prototype.toggleButtonPrev = function (visible) {
        if ($.type(visible) != 'boolean') {
            visible = true;
        }
        var button = this.getButtonPrev(),
            from = visible ? -button.outerWidth()+'px' : '0px',
            to = visible ? '0px' : -button.outerWidth()+'px';
        if (button.is(':visible') && button.css('margin-left') == to) {
            return;
        }
        button.css('margin-left', from);
        if (visible) {
            button.toggle(true);
        }
        button.animate({
            marginLeft: to
        });
    }

    BootstrappTab.prototype.toggleButtonNext = function (visible) {
        if ($.type(visible) != 'boolean') {
            visible = true;
        }
        var button = this.getButtonNext(),
            from = visible ? -button.outerWidth()+'px' : '0px',
            to = visible ? '0px' : -button.outerWidth()+'px';
        if (button.is(':visible') && button.css('margin-right') == to) {
            return;
        }
        button.css('margin-right', from);
        if (visible) {
            button.toggle(true);
        }
        button.animate({
            marginRight: to
        });
    }


    // TAB PLUGIN DEFINITION
    // =====================

    $.fn.bootstrappTab = function ( option ) {
        return this.each(function () {
            var $this = $(this);
            var data  = $this.data('bootstrapp.tab');
            var refresh = false;

            if (!data) {
                $this.data('bootstrapp.tab', (data = new BootstrappTab(this)))
            } else {
                refresh = true;
            }
            if (typeof option == 'string') {
                data[option]();
            } else if (refresh) {
                data.refresh();
            }
        })
    }

    $.fn.bootstrappTab.Constructor = BootstrappTab

}(jQuery);