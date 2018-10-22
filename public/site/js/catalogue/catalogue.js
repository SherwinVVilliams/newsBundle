"use strict";

$(document).ready(function () {
    btnHover();
    catalog__filter();
    // Masonary();
    // collage();
    apend__shop();

});

function catalog__filter() {
    $('.cat__filer-js').on('click', 'li:not(.active)', function () {
        $(this)
            .addClass('active').siblings().removeClass('active')
            .closest('.catalogue').find('.catalog__shops-content').removeClass('active').eq($(this).index()).addClass('active');
    });
}


function Masonary() {
    $(window).on('load resize', function () {
        var w = $(window).width();
        var slideBlock = $('.gride');
        if(w>766){
            if(!slideBlock.hasClass('masonry')){
                slideBlock.addClass('masonry');
                slideBlock.masonry({
                    gutter: 30,
                    columWidth: 255
                });
            }
        }
        else{
            if(slideBlock.hasClass('masonry')){
                slideBlock.masonry('destroy');
                slideBlock.removeClass('masonry');
            }
        }
    });


    // masonory end
}

function apend__shop() {
            $('.catalog__shops-content.active').find('.categories__btn-ajax').click(function (e) {
            e.preventDefault();
            $.getJSON('/js/catalogue/server.json').done(function (data) {
                for (var a in data) {
                    var gridJs = $('.catalog__shops-content.active').find('.grid__catalogue-row');
                    gridJs.append($('<div class="col-lg-3 col-md-4 col-sm-6"><a href="#js_shop" class="modal-trigger"><div class="item">\n' +
                        '<div class="shown  '+ data[a].class +'">\n' +
                       '<div class="shown__item-foto">\n' +
                       '<div class="catalogue__logo">\n' +
                        '<img class="element-item" src="' + data[a].img + '" alt="">\n' +
                        '</div>\n' +
                       '</div>\n' +
                        '<div class="shops__item-text">\n' +
                        '<span>' + data[a].name + '</span>\n' +
                        '</div>\n' +
                    '</div>\n' +
                   '</div></a></div>'));
                    $(".modal-trigger").fancybox();

                }
            });
            this.scrollIntoView(false);
            // $('.categories__btn-ajax').addClass('btn__hide');
        });
}
function btnHover() {
    var w = $(window).width();
    if(w<992){
        $('.categories__btn-ajax').removeClass('button__orange').addClass('btn__no-hover');
    }

}


