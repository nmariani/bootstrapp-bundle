$.fn.bootstrappSelect2 = function(options) {
    var select2;
    this.each(function(offset, element){
        var opts = $.extend({}, options);
        element = $(element);
        if(element.is('select')) {
            var choices = element.data('choices');
            if (typeof choices != 'undefined') {
                opts.data = choices;
            }
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
        }
        select2 = element.select2(opts);
    });
    return select2;
};