$(function () {
    Parallax_main();
    collage();
    filter_models();
    qustion_main();
    open_lastOrder();
    reviews__slider();
    planeta();
    menu_class();
    up_arrow();
    close_order();

    new WOW().init({
        offset: 200,
        disable: 'mobile'
    });
    AOS.init({
        offset: 200,
        disable: 'mobile'
    });
    send_to_tabs();
    sendTabs();
    close_tab();
    useful_now();
})




function useful_now() {
    if ($(window).width() < 766) {
        $('.useful-now__information').addClass('owl_useful-now owl-carousel');
        $('.owl_useful-now').owlCarousel({
            slidesToShow: 1,
            slidesToScroll: 1,
            loop: true,
            autoHeight: true,
            nav: true,
            item: 1,
            dots: true,
            navText: ["", ""],
            responsive: {
                0: {
                    items: 1
                },
            }
        })
    }
}

function sendTabs() {
    $('.r-col .send_to_tabs').click(function (e) {
        /* тут проверка если пользователь зареестрирован, если да то следующий код, если нет то папоп с входом на сайт    */
        e.preventDefault();
        $(this).parents('.r-col').toggleClass('addTabsActive');
        $(this).parents('.r-col').toggleClass('active__tab__login');
        $(this).parents('.r-col').find('.close__tab').css('display', 'block');
        $(this).parents('.r-col').find('a').text('В закладках');
    })
}

function close_tab() {
    $('.close__tab').click(function () {
        $(this).parents('.r-col').removeClass('addTabsActive').removeClass('active__tab__login');
        $(this).parents('.r-col').find('a').text('В закладки');
        $(this).parents('.r-col').find('.close__tab').css('display', 'none');

    })
}


function reviews__slider() {
    $(".reviews__slider").owlCarousel({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplayTimeout: 6000,
        loop: true,
        autoHeight: true,
        autoplayHoverPause:true,
        nav: true,
        item: 1,
        dots: true,
        navText: ["", ""],
        responsive: {
            0: {
                items: 1
            },
            481: {
                items: 1
            },
            765: {
                items: 2
            },
            1023: {
                items: 3
            },
        }
    });
}


function qustion_main() {
    var w = $(window).width();
    $(".tabs_questions__title").click(function (e) {
        e.preventDefault();
        $('.tabs_questions__title h5').removeClass('active__title');
        if ($(this).hasClass('active__acord')) {
            $(this).removeClass("active__acord");
            $(this).siblings('.tabs_questions__information').slideUp(500);
            $(this).find('h5').removeClass('active__title');
            $(this).find("i").removeClass("fa-minus").addClass("fa-plus");
        } else {
            $(this).find('h5').addClass('active__title');
            if (w > 576) {
                $(".tabs_questions__title i").removeClass("fa-minus").addClass("fa-plus");
                $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
                $(".tabs_questions__title").removeClass("active__acord");
                $(this).addClass("active__acord");
                $('.tabs_questions__information').slideUp(500);
                $(this).siblings('.tabs_questions__information').slideDown(500);
            }
            else {
                $(this).find("i").removeClass("fa-plus").addClass("fa-minus");
                $(this).addClass("active__acord");
                $(this).siblings('.tabs_questions__information').slideDown(500);
            }
        }
    });
};

function planeta() {
    $(window).scroll(function () {
        if ($(window).width() > 766) {
            var scroll_planeta = $('.shopping').offset().top;
            if ($(this).scrollTop() > scroll_planeta) {
                setTimeout(function () {
                    $('#line4').fadeIn(1000);

                }, 100);
                setTimeout(function () {
                    $('#line11').fadeIn(1000);

                }, 300);
                setTimeout(function () {
                    $('.z_1').fadeIn(1000);

                }, 500);
                setTimeout(function () {
                    $('.z_1_2').fadeIn(1000);

                }, 700);

                setTimeout(function () {
                    $('#line2').fadeIn(1000);

                }, 900);
                setTimeout(function () {
                    $('#line22').fadeIn(1000);

                }, 1100);
                setTimeout(function () {
                    $('.z_2').fadeIn(2000);

                }, 1300);
                setTimeout(function () {
                    $('.z_2_1').fadeIn(1000);

                }, 1500);


                setTimeout(function () {
                    $('#line1').fadeIn(1000);

                }, 1700);
                setTimeout(function () {
                    $('#line33').fadeIn(1000);

                }, 1900);
                setTimeout(function () {
                    $('.z_3').fadeIn(1000);

                }, 2100);
                setTimeout(function () {
                    $('.z_3_1').fadeIn(1000);

                }, 2300);
                setTimeout(function () {
                    $('#line3').fadeIn(1000);

                }, 2500);
                setTimeout(function () {
                    $('#line0').fadeIn(1000);

                }, 2700);
            }
        }
    })
}


function menu_class() {
    if ($(window).width() < 766) {
        $('.row .col-md-12').removeClass('media_col');
    }

}


function open_lastOrder() {
    if ($(window).width() > 766) {
        setTimeout("$('.last-order').show('drop');", 5000);
    }
}


function close_order() {
    $('.close_order').click(function () {
        $('.last-order').hide();
    })
}

function canvas() {
    $(window).scroll(function () {
        var scroll_canvas = $('.show__other__answers').offset().top;
        if ($(this).scrollTop() > scroll_canvas) {
            setTimeout(function () {
                var canvas = $("#paper")[0];
                var c = canvas.getContext("2d");
                c.lineWidth = 20; // толщина линии
                var startX = 0;
                var startY = 20;
                var endX = 1920;
                var endY = 20;
                var amount = 0;
                setInterval(function () {
                    amount += 0.05; // change to alter duration
                    if (amount > 1) amount = 1;
                    c.clearRect(0, 0, canvas.width, canvas.height);
                    c.strokeStyle = "#b9b9b9";
                    c.moveTo(startX, startY);
                    // lerp : a  + (b - a) * f
                    c.lineTo(startX + (endX - startX) * amount, startY + (endY - startY) * amount);
                    c.stroke();
                }, 10);
            })
        }
    })

}


function up_arrow() {

    $('.up-arrow').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500);
        return false;
    })
}


function send_to_tabs() {
    var owl = $('.col_together'),
        owlOptions = {
            slidesToShow: 1,
            slidesToScroll: 1,
            autoHeight: true,
            nav: true,
            item: 1,
            dots: true,
            navText: ["", ""],
            responsive: {
                0: {
                    items: 1
                },
                481: {
                    items: 1
                },
                767: {
                    items: 2
                },
            }
        };

    if ($(window).width() < 992) {
        var owlActive = owl.owlCarousel(owlOptions);
    } else {
        owl.addClass('off');
    }

    $(window).resize(function () {
        if ($(window).width() < 992) {
            if ($('.owl-carousel').hasClass('off')) {
                var owlActive = owl.owlCarousel(owlOptions);
                owl.removeClass('off');
            }
        } else {
            if (!$('.owl-carousel').hasClass('off')) {
                owl.addClass('off').trigger('destroy.owl.carousel');
                owl.find('.owl-stage-outer').children(':eq(0)').unwrap();
            }
        }
    });
}

function Parallax_main() {
    var parallax_first = document.getElementById('parallax');
    var parallaxInstance = new Parallax(parallax_first);
    // parallaxInstance.limit(false, 1)

}

function collage() {
    if ($(window).width() < 766) {
        $(".gride").addClass('owl-carousel');
        $(".gride").owlCarousel({
            slidesToShow: 1,
            slidesToScroll: 1,
            loop: true,
            dots: false,
            autoHeight: true,
            nav: true,
            item: 1,
            navText: ["", ""],
            responsive: {
                0: {
                    items: 1
                },
                481: {
                    items: 1
                },
            }
        })
    }
}

function filter_models() {
    $('.shopping-shops__tabs__content>div:not(":first-of-type")').hide();
    $('.shopping-shops__tabs__title li').each(function (i) {
        $(this).attr('data-tab', 'tab' + i);
    });
    $('.shopping-shops__tabs__content .shopping-shops__tabs__choice').each(function (i) {
        $(this).attr('data-tab', 'tab' + i);
    });
    $('.shopping-shops__tabs__title li').on('click', function (e) {
        e.preventDefault();
        var dataTab = $(this).data('tab');
        var getWrapper = $(this).closest('.shop-wrap');
        getWrapper.find('.shopping-shops__tabs__title li').removeClass('active');
        $(this).addClass('active');
        getWrapper.find('.shopping-shops__tabs__content>.shopping-shops__tabs__choice').hide();
        getWrapper.find('.shopping-shops__tabs__content>.shopping-shops__tabs__choice[data-tab=' + dataTab + ']').show();
    });
}

