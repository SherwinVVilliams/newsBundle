$(function () {
    up_arrow();
    SelectStyle();
    FotterHeight();
    activeMenu();
    headerLK();
    // cange__number();
    hover__sendToTabs();
    come_shop_hover();
    Validate_main();
});



function activeMenu() {
    if ($(window).width() > 1024) {
        var location = window.location.href;
        var cur_url = '/' + location.split('/').pop();

        $('.header__menu ul li').each(function () {
            var link = $(this).find('a').attr('href');

            if (cur_url == link) {
                $(this).addClass('activeMenu');
            }
        });
    }
    else{
        var location = window.location.href;
        var cur_url = '/' + location.split('/').pop();

        $('.header__menu ul li').each(function () {
            var link = $(this).find('a').attr('href');

            if (cur_url == link) {
                $(this).addClass('activeMenuMobile');
            }
        });
    }
}

function up_arrow() {
    $('.up-arrow').click(function () {
        $('html, body').animate({scrollTop: 0}, 1500);
        return false;
    })
}


function SelectStyle() {
    $('select').styler();

}

function FotterHeight() {
    $(window).on('load',function () {
        var heightFooter = $('.content__wrap').height() - $(window).height();
        var HeightInt = parseInt(heightFooter-32);
        $('.class_height').css('padding-bottom', -HeightInt);

    })
}

function headerLK() {
        $('.header-lk').parent('.content__wrap').addClass('content__wrap-lk');
}
function cange__number() {
    $('input[type=tel]').on('keydown', function(e){
        if(e.key.length == 1 && e.key.match(/[^0-9'".]/)){
            return false;
        };
    })
}
function hover__sendToTabs() {
    $('.r-col a').addClass('send_to_tabs-active');
    var x = $(window).width();
    if(x<992){
        $('.r-col a').removeClass('send_to_tabs-active');
    }
}

function come_shop_hover() {
    $('.together-cheaper__item__come-shop a').addClass('come-shop-hover');
    var x = $(window).width();
    if(x<992){
        $('.together-cheaper__item__come-shop a').removeClass('come-shop-hover');
    }
}
function Validate_main() {
    $("#js_enterSite form").validate({
        rules: {
            name: {
                required: true,
            },

            email: {
                required: true,
                email: true
            },
            password: {
                required: true,
                regex: /(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$/g,
            }

        },
        messages: {
            name: {
                required: "Заполните поле",
            },
            email: {
                required: "Заполните поле",
                email: "Введите  корректный адрес",
            },
            password: {
                required: "Заполните поле",
                regex: "Пароль не правильный",
            }

        }
    });
}


