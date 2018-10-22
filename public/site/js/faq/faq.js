"use strict";
$(function () {
    $(".modal-trigger").fancybox();
    question__accordion();
    tabs__faq();
    scroll();
    close__quest();

});

function scroll() {
    var w = $(window).width();
    if (w < 767) {
        $('.tabs__caption li ').click(function () {
            // $('html,body').animate({scrollTop: 350}, 500);
            $("html, body").animate({ scrollTop: $('.tabs__content.active').offset().top }, 500);
        })
    }

}

function tabs__faq() {

    $('ul.tabs__caption').on('click', 'li:not(.active)', function () {
        var tabContent = $('.line__title');
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('div.faq__tabs').find('div.tabs__content').removeClass('active')
            .eq($(this).index()).addClass('active');
        tabContent.removeClass("active__acord");
        $('.quest__text').hide();
        tabContent.find("i").removeClass("fa-minus").addClass("fa-plus");
    });

}
function close__quest() {

}
function question__accordion() {

    var w = $(window).width();
    $(".line__title").click(function (e) {
        e.preventDefault();
        if ($(this).hasClass('active__acord')) {
            $(this).removeClass("active__acord");
            $(this).siblings('.quest__text').slideUp(500);
            $(this).find("i").removeClass("fa-minus").addClass("fa-plus");
        } else {
            if(w>768){
                $(".line__title i").removeClass("fa-minus").addClass("fa-plus");
                $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
                $(".line__title").removeClass("active__acord");
                $(this).addClass("active__acord");
                $('.quest__text').slideUp(500);
                $(this).siblings('.quest__text').slideDown(500);
            }
            else{
                $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
                $(this).addClass("active__acord");
                $(this).siblings('.quest__text').slideDown(500);
            }
        }


    });

    // accordion start

    // accordion end
}

