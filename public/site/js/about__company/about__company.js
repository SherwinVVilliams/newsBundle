"use strict";
$(document).ready(function () {
    var w = $(window).width();
        if(w>768){
            new WOW().init({
                offset: 200,
                disable: 'mobile'
            });
        }

    AOS.init({
        disable: 'mobile'
    });
    reviews__slider();
    map__Height();
});
function reviews__slider() {
    $(".reviews__slider").owlCarousel({
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
function initMap() {

    var element = document.getElementById('map__about');
    var options ={
        zoom:10,
        center:{lat:52.280511, lng: 104.283577},
    };
    var myMap = new google.maps.Map(element,options);

    var icon = {
        url: "img/about__company/icon__contact/Geolocation.svg", // url
        scaledSize: new google.maps.Size(55, 66) // scaled size

    };
    var marker = new google.maps.Marker({
        position:{lat:52.280511, lng: 104.283577},
        map:myMap,
        icon:icon

    })

}
function map__Height(){
    $(window).on('load resize', function () {
        var height = $( '#contact__info' ).height(); //получаем высоту одного элемента
        $( '#map__about' ).height(height); //записываем высоту другому элементу
    })
}

