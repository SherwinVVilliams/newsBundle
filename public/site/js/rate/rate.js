$(document).ready(function () {
    irkutsk__tabs();
    global__tabs();
    things();
    child__acord();
    rate__fancybox();
    mask_Phone();
    cities();
});

function irkutsk__tabs() {

    $('ul.irkutsk__caption').on('click', 'li:not(.active)', function () {
        $(this)
            .addClass('active').addClass('irkutsk__active-before').siblings().removeClass('active').removeClass('irkutsk__active-before')
            .closest('div.irkutsk__tabs').find('div.irkutsk__content').removeClass('active').eq($(this).index()).addClass('active');
    });

};

function global__tabs() {

    $('ul.global__caption').on('click', 'li:not(.active)', function () {
        $(this)
            .addClass('active').addClass('irkutsk__active-before').siblings().removeClass('active').removeClass('irkutsk__active-before')
            .closest('div.global__tabs').find('div.global__content').removeClass('active').eq($(this).index()).addClass('active');
    });
    $('.owl-carousel').owlCarousel({
        nav: true,
        navText: ["", ""],
        responsive: {
            1200: {
                items: 4
            },
            992: {
                items: 4
            },
            768: {
                items: 3
            },
            576: {
                items: 2
            },
            320: {
                items: 1
            }
        }

    });


};

function things() {
    $(window).on('load resize', function () {
        var w = $(window).width();
        if (w < 576) {
            $('.things__title i').removeClass('fa-minus').addClass("fa-plus");
        }
        else {
            $('.things__title i').removeClass('fa-plus').addClass("fa-minus");
        }
    });

    $('.things__title').click(function () {
        $(this).siblings('.things__content').toggle('normal');
        $('.panel').hide();
        $('.goods__child-arrow').removeClass('transform__accord');
        $(this).find('i').toggleClass('fa-plus').toggleClass('fa-minus');
    });


}

function child__acord() {

    $('.accord').click(function () {
        $(this).siblings('.panel').toggle('normal');
        $(this).find('.goods__child-arrow').toggleClass('transform__accord');
    })
}

function rate__fancybox() {
    // $('.rate__btn-fancybox').click(function () {
    //     $('.js__answer-wrap').hide();
    //     $('.rate__popup-after').show();
    // })
}

function mask_Phone() {
    $(".maskPhone").mask("8(999) 999-9999");
}

function cities() {
    var availableTags = [
        "Москва",
        "Уфа",
        "Санкт-Петербург",
        "Иркутск",
        "Владивосток",
        "Калининград",
        "Астрахань"

    ];
    $(".calc__where").autocomplete({
        source: availableTags
    });
}




