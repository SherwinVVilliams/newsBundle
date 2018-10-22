'use strict'
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
});