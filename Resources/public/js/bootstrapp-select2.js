$.fn.bootstrappSelect2 = function(options) {
    this.each(function(offset, element){
        var opts = $.extend({}, options);
        element = $(element);
        if(element.is('select')) {
            var choices = element.data('choices');
            if (typeof choices != 'undefined') {
                opts.data = choices;
                var id = element.attr('id'),
                    name = element.attr('name'),
                    value = element.val();
                element.replaceWith(
                    $('<input type="hidden" id="' + id + '" name="'+ name +'" value="'+ value +'">')
                );
                element = $('#'+id);
            }
        }
        element.select2(opts);
    });
};