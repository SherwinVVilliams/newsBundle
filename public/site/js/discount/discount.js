$(function () {
    SelectStyle();
    AOS.init({
        offset: 200,
        disable: 'mobile'
    });
})

function SelectStyle() {
    $('select').styler();
}

(function($) {
    $(function() {

        $('select').styler();

    });
})(jQuery);