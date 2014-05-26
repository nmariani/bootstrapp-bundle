/*!
 * bootstrapp-form.js v1.0.0
 *
 * Copyright (c) 2012-2014, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
+function ($) {
    'use strict';

    // FORM CLASS DEFINITION
    // ====================

    var BootstrappForm = function (element) {
        this.element = $(element);
        if (this.element.is('form')) {
            this.refresh();
        }
    }

    BootstrappForm.prototype.refresh = function () {
        // fieldset toggle
        this.element.find('fieldset > legend[data-toggle=collapse]').click(function(){
            $(this).nextAll().collapse('toggle');
            $(this).children().filter('i').toggleClass('icon-chevron-right').toggleClass('icon-chevron-down');
        });
    }


    // FORM PLUGIN DEFINITION
    // =====================

    $.fn.bootstrappForm = function ( option ) {
        return this.each(function () {
            var $this = $(this);
            var data  = $this.data('bootstrapp.form');
            if (!data) {
                $this.data('bootstrapp.form', (data = new BootstrappForm(this)))
            }
            if (typeof option == 'string') {
                data[option]();
            }
        })
    }

    $.fn.bootstrappForm.Constructor = BootstrappForm

}(jQuery);