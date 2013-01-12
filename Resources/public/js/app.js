/*!
 * app.js v1.0.0
 *
 * Copyright (c) 2012, Nathanaël Mariani <github@nmariani.fr>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
(function ( $ ) {
/*
    $('body').on('click.modal.data-api', '[data-modal^="#"]', function ( e ) {
        var $this = $(this), $target = $($this.attr('data-modal'));
        e.preventDefault();
        $target.modal('show');
    })
*/
    $(document).ready(function() {
        $('[data-modal^="#"]').each(function () {
            var $this = $(this),
                modal = $($this.data('modal'))
            ;

            // prevent onclick from being dispatched
            $this.attr('onclick', "if($(this).data('modal-confirm')!=true) return false; "+$this.attr('onclick'));

            $this.click(function (e) {
                var $this = $(this),
                    modalButton = modal.find(".modal-footer a.btn-primary")
                ;

                // show modal
                modal.modal('show');

                // update modal body content
                $($this.data('modal')+" .modal-body p").html($this.data('modal-body'));

                // update modal button href and target attributes
                modalButton.attr('href', $this.attr('href')||'#');
                if($this.attr('target'))
                    modalButton.attr('target', $this.attr('target'));
                else modalButton.removeAttr('target');

                // fire element click on modal button click
                modalButton.click(function (e) {
                    $this.data('modal-confirm', true);
                    $this.click();
                });
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