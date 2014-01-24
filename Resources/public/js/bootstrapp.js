/*!
 * app.js v1.0.0
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function ( $ ) {
    $(document).ready(function() {
        $('[data-modal]').each(function () {
            var $this = $(this),
                modal = $this.data('modal') ? $($this.data('modal')) : $('#modal-ask')
            ;

            if (modal.length == 0) {
                return;
            }

            // prevent onclick from being dispatched
            $this.attr('onclick', "if($(this).data('modal-confirm')!=true) return false; "+$this.attr('onclick'));

            $this.click(function (e) {
                var $this = $(this),
                    header = $this.data('modal-header'),
                    body = $this.data('modal-body'),
                    modalButton = modal.find(".modal-footer a:not([data-dismiss])")
                ;
                if (!$this.data('modal-confirm')) {
                    e.stopImmediatePropagation();
                    e.preventDefault();

                    // show modal
                    modal.modal('show');

                    // update modal header content
                    if (header) {
                        $($this.data('modal')+" .modal-header > h4").first().html(header);
                    }

                    // update modal body content
                    if (body) {
                        $($this.data('modal')+" .modal-body > p").first().html(body);
                    }

                    // update modal button href and target attributes
                    modalButton.attr('href', $this.attr('href')||'#');
                    if($this.attr('target')) {
                        modalButton.attr('target', $this.attr('target'));
                    } else {
                        modalButton.removeAttr('target');
                    }

                    // remove all handlers attached
                    modalButton.off();

                    // fire element click on modal button click
                    modalButton.click(function (e) {
                        $this.data('modal-confirm', true);
                        var e = $.Event('click');
                        $this.trigger(e);
                        if (!e.isDefaultPrevented() && !e.isPropagationStopped() && !e.isImmediatePropagationStopped()) {
                            modal.modal('hide');
                            $this.data('modal-confirm', false);
                        }
                    });
                }
            });
        });

        /*!
         * Convert <select> elements to Dropdown Group
         *
         * Author: John Rocela 2012 <me@iamjamoy.com>
         */
/*
        jQuery(function($){
            $('select.dropdown').each(function(i, e){
                if (!($(e).data('convert') == 'no')) {
                    var options = $(e).find('option');
                    $(e).hide().wrap('<div class="btn-group" id="select-group-' + i + '" />');
                    var select = $('#select-group-' + i);
                    var current = ($(e).val()) ? $(e).val(): '&nbsp;';
                    select.html('<input type="hidden" value="' + $(e).val() + '" name="' + $(e).attr('name') + '" id="' + $(e).attr('id') + '" class="' + $(e).attr('class') + '" />' +
                        '<a class="btn" href="javascript:;">' + current + '</a>' +
                        '<a class="btn dropdown-toggle" data-toggle="dropdown" href="javascript:;"><span class="caret"></span></a>' +
                        '<ul class="dropdown-menu"></ul>');
                    options.each(function(o,q) {
                        select.find('.dropdown-menu').append('<li><a href="javascript:;" data-value="' + $(q).attr('value') + '">' + $(q).text() + '</a></li>');
                        if ($(q).attr('selected')) {
                            //select.find('.dropdown-menu li:eq(' + o + ')').click();
                            select.find('.btn:eq(0)').text($(q).text());
                        }
                    });
                    select.find('.dropdown-menu a').click(function() {
                        select.find('input[type=hidden]').val($(this).data('value')).change();
                        select.find('.btn:eq(0)').text($(this).text());
                    });
                    select.find('a.dropdown-toggle').dropdown();
                }
            });
        });
*/
    });
})( jQuery );