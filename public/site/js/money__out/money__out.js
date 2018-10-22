$(document).ready(function () {
    click__radio();
    new WOW().init({
        offset: 200,
        disable: 'mobile'
    });
    FotterHeight2();
    // scrollBlock();
    if (navigator.userAgent.match(/like Mac OS X/i)) {
        scrollBlock();
    }
});

function click__radio() {
    $('.outmoney__table-radio').click(function () {
        $(this).find('.radio__click').addClass('outmoney__radio-before').parents('.outmoney__row').siblings().find('.radio__click').removeClass('outmoney__radio-before');

    });
}

function FotterHeight2() {
    $(window).on('load',function () {
        var heightFooter = $('.content__wrap').height() - $(window).height();
        var title= $('.invoice__top').height();
        var HeightInt = parseInt(heightFooter - title -32);
        $('.class__height').css('padding-bottom', -HeightInt);

    })
}
function scrollBlock() {
    $(".outmoney__table-wrap").niceScroll(".outmoney__table",{
        cursorwidth:12,
        cursoropacitymin:0.4,
        cursorcolor:'#6e8cb6',
        cursorborder:'none',
        cursorborderradius:4

    });

}

