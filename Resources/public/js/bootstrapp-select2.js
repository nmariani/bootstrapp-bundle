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
                        value = element.val(),
                        events = $._data(element.get(0), "events");
                    // replace element by an hidden input
                    element.replaceWith(
                        $('<input type="hidden" id="' + id + '" name="'+ name +'" value="'+ value +'">')
                    );
                    // retrieve new hidden input element
                    element = $('#'+id);
                    // bind previously attached handlers to new element
                    if ($.isPlainObject(events)) {
                        $.each(events, function(event, handlers){
                            $.each(handlers, function(index, handler) {
                                element.on(event, handler);
                            })
                        });
                    }
                    break;
                default :
                    break;
            }
        } else if (element.is('input')) {
            values = element.val().split(",");
        }
        if (opts.data && opts.data.text) {
            if (!opts.formatSelection) {
                if ($.isFunction(opts.data.text)) {
                    opts.formatSelection = opts.data.text;
                } else if ($.type(opts.data.text) == 'string') {
                    opts.formatSelection = function (item) { return item[opts.data.text]; };
                }
            }
            if (!opts.formatResult) {
                if ($.isFunction(opts.data.text)) {
                    opts.formatResult = opts.data.text;
                } else if ($.type(opts.data.text) == 'string') {
                    opts.formatResult = function (item) { return item[opts.data.text]; };
                }
            }
        }
        select2 = element.select2(opts);
        if (!element.val() && opts.selectSingleValue && values.length == 1) {
            element.select2('val', values[0], true);
        }
    });
    return select2;
};