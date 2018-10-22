'use strict'
$(document).ready(function () {
    table__order();
    ColorMenu();
    dataTable1();
    orderCheck();
    click__radio();
    dataTable3();
    lk__Slider();
    // lk__Slider_popup();
    // slider__popup2();
    fancy__photo();
    dataTable4();

});

function table__order() {

    $('ul.tableTwo__caption').on('click', 'li:not(.active)', function () {
        $(this)
            .addClass('active').addClass('tableTwo__active-before')
            .siblings().removeClass('active').removeClass('tableTwo__active-before')
            .closest('div.lkOrder__tableTwo').find('.tableOne__tbody').find('.tableTwo__tbody-content')
            .removeClass('active').eq($(this).index()).addClass('active');;
    });

};

function ColorMenu() {
    $('.menuTable__list a').click(function (e) {
       e.preventDefault();
       $(this).parent('li').addClass('active').siblings().removeClass('active')
    });
}
function dataTable1() {
    $('#table_id').DataTable({

        paging: false,
        searching:false,
        "info":  false,
        responsive: {
            breakpoints: [
                {name: 'bigdesktop', width: Infinity},
                {name: 'meddesktop', width: 1480},
                {name: 'smalldesktop', width: 1280},
                {name: 'medium', width: 1188},
                {name: 'tabletl', width: 1024},
                {name: 'btwtabllandp', width: 848},
                {name: 'tabletp', width: 768},
                {name: 'mobilel', width: 480},
                {name: 'mobilep', width: 320}
            ]
        },
        "columnDefs": [
            { "orderable": false,
                "targets": 1
            },
            { "orderable": false,
                "targets": 2
            },
            { "orderable": false,
                "targets": 4
            }

        ]
    });
}
function dataTable3() {

    var table = $('#table_id2').DataTable( {

        paging: false,
        searching:false,
        "info":  false,
        ordering:false,
        responsive: true
    } );

    table.on( 'responsive-resize', function ( e, datatable, columns ) {
        var count = columns.reduce( function (a,b) {
            return b === false ? a+1 : a;
        }, 0 );

        console.log( count +' column(s) are hidden' );
    } );
}
function dataTable4() {

    var table = $('#table_id3').DataTable( {

        paging: false,
        searching:false,
        "info":  false,
        ordering:false,
        responsive: true
    } );

    table.on( 'responsive-resize', function ( e, datatable, columns ) {
        var count = columns.reduce( function (a,b) {
            return b === false ? a+1 : a;
        }, 0 );

        console.log( count +' column(s) are hidden' );
    } );
}
function orderCheck() {
    $('.tableOrder__check').find('input').click(function () {

        if($(this).is(':checked')){
            $(this).parent('label').addClass('label__ckeck-icon');
        }
        else{
            $(this).parent('label').removeClass('label__ckeck-icon');
        }
    })
}
function click__radio() {
    $('.lineOrder__radio-item').click(function () {
        $(this).find('label').addClass('outmoney__radio-before').parents('.lineOrder__radio-item').siblings().find('label').removeClass('outmoney__radio-before');

    });
}

function lk__Slider_popup() {
   var dotcount = 1;

    $(".slider__infoTrack-popup.owl-carousel").owlCarousel({
        items: 1,
        margin: 10,
        nav: true,
        autoHeight: true,
        loop:true
    });

    $('.slider__infoTrack-popup .owl-dot').each(function() {
        $(this).addClass('dotnumber' + dotcount);
        $(this).attr('data-info', dotcount);
        dotcount = dotcount + 1;
    });

   var slidecount = 1;

    $('.slider__infoTrack-popup .owl-item').not('.cloned').each(function() {
        $(this).addClass('slidenumber' + slidecount);
        slidecount = slidecount + 1;
    });

    $('.slider__infoTrack-popup .owl-dot').each(function() {
        var grab = $(this).data('info');
        var slidegrab = $('.slidenumber' + grab + ' img').attr('src');
        var slide = '<img src="' + slidegrab + '">';
        $(this).append(slide)
    });

   var amount = jQuery('.slider__infoTrack-popup .owl-dot').length;
    var gotowidth = 100 / amount;

    $('.slider__infoTrack-popup .owl-dot').css("width", gotowidth + "%");
    var newwidth = $('.slider__infoTrack-popup .owl-dot').width();
    $('.slider__infoTrack-popup .owl-dot').css("height", newwidth + "px");
}
function lk__Slider() {
    $(".slider__infoTrack.owl-carousel").owlCarousel({
        items: 3,
        margin: 10,
        nav    : true,
        autoHeight: true,
        loop:true,
        responsiveClass:true,
        responsive:{
            991:{
                items: 3
            },
            767:{
                items: 4
            },
            320:{
                items: 2
            }
        }
    });
}
function slider__popup2() {
    var sync1 = $("#sync1");
    var sync2 = $("#sync2");
    var slidesPerPage = 4; //globaly define number of elements per page
    var syncedSecondary = true;

    sync1.owlCarousel({
        items: 1,
        slideSpeed: 2000,
        nav: true,
        autoplay: false,
        dots: false,
        loop: true,

        responsiveRefreshRate: 200,
        navText: ['<svg width="100%" height="100%" viewBox="0 0 11 20"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M9.554,1.001l-8.607,8.607l8.607,8.606"/></svg>', '<svg width="100%" height="100%" viewBox="0 0 11 20" version="1.1"><path style="fill:none;stroke-width: 1px;stroke: #000;" d="M1.054,18.214l8.606,-8.606l-8.606,-8.607"/></svg>'],
    }).on('changed.owl.carousel', syncPosition);

    sync2
        .on('initialized.owl.carousel', function() {
            sync2.find(".owl-item").eq(0).addClass("current");
        })
        .owlCarousel({
            items: slidesPerPage,
            dots: false,
            nav: false,
            smartSpeed: 200,
            slideSpeed: 500,
            margin: 10,
            slideBy: slidesPerPage, //alternatively you can slide by 1, this way the active slide will stick to the first item in the second carousel
            responsiveRefreshRate: 100,
            responsive:{
                320:{
                    items:2
                },
                500:{
                    items:3
                },
                576:{
                    items: slidesPerPage
                }
            }
        }).on('changed.owl.carousel', syncPosition2);

    function syncPosition(el) {
        //if you set loop to false, you have to restore this next line
        //var current = el.item.index;

        //if you disable loop you have to comment this block
        var count = el.item.count - 1;
        var current = Math.round(el.item.index - (el.item.count / 2) - .5);

        if (current < 0) {
            current = count;
        }
        if (current > count) {
            current = 0;
        }

        //end block

        sync2
            .find(".owl-item")
            .removeClass("current")
            .eq(current)
            .addClass("current");
        var onscreen = sync2.find('.owl-item.active').length - 1;
        var start = sync2.find('.owl-item.active').first().index();
        var end = sync2.find('.owl-item.active').last().index();

        if (current > end) {
            sync2.data('owl.carousel').to(current, 100, true);
        }
        if (current < start) {
            sync2.data('owl.carousel').to(current - onscreen, 100, true);
        }
    }

    function syncPosition2(el) {
        if (syncedSecondary) {
            var number = el.item.index;
            sync1.data('owl.carousel').to(number, 100, true);
        }
    }

    sync2.on("click", ".owl-item", function(e) {
        e.preventDefault();
        var number = $(this).index();
        sync1.data('owl.carousel').to(number, 300, true);
    });
}
function fancy__photo() {
    $(".modal-trigger2").fancybox();
     slider__popup2();
}

