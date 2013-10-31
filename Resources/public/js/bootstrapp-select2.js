$.fn.bootstrappSelect2 = function(options) {
    var select2;
    this.each(function(offset, element){
        var opts = $.extend({}, options),
            values = [];
        element = $(element);
        if (element.is('select')) {
            var choices = element.data('choices');
            if (typeof choices != 'undefined') {
                opts.data = choices;
            }
            element.find('option').each(function(index, option){
                if ($(option).val()) {
                    values.push($(option).val());
                }
            });
            switch (true) {
                case typeof(opts.data) != 'undefined' :
                case typeof(opts.tags) != 'undefined' :
                    var id = element.attr('id'),
                        name = element.attr('name'),
                        value = element.val();
                    element.replaceWith(
                        $('<input type="hidden" id="' + id + '" name="'+ name +'" value="'+ value +'">')
                    );
                    element = $('#'+id);
                    break;
                default :
                    break;
            }
        } else if (element.is('input')) {
            values = element.val().split(",");
        }
        select2 = element.select2(opts);
        if (opts.selectSingleValue && values.length == 1) {
            element.select2('val', values[0], true);
        }
    });
    return select2;
};