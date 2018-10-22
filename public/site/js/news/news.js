"use strict";
$(document).ready(function () {
    new WOW().init({
        offset: 200,
        disable: 'mobile'
    });

    AOS.init({
        disable: 'mobile'
    });
    share();
    descnews__Ownl();
});
function descnews__Ownl() {
    $(window).on('load resize', function () {
        if ($(window).width() < 766) {
            $('.helpful__blocks').addClass('owl_useful-now owl-carousel');
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
    });

}
function news__tabs() {
    
}


function share() {
        if (window.pluso)if (typeof window.pluso.start == "function") return;
        if (window.ifpluso==undefined) { window.ifpluso = 1;
            var d = document, s = d.createElement('script'), g = 'getElementsByTagName';
            s.type = 'text/javascript'; s.charset='UTF-8'; s.async = true;
            s.src = ('https:' == window.location.protocol ? 'https' : 'http')  + '://share.pluso.ru/pluso-like.js';
            var h=d[g]('body')[0];
            h.appendChild(s);
        };
}