$(document).ready(function () {
    form.init();
});

var form = function ($) {
    var init = function () {
        $('form').submit(function (e) {
            e.preventDefault();
            var that = $(this);
            $.post(that.attr('action'), that.serialize()).done(function (response) {
                that.find('.messages').html(response);
                that.find('fieldset').hide();
            });
        });
    };
    return {
        init: function (element) {
            init();
        }
    };
}($);
