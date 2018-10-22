$(function () {
    slider__akcii();

})



function slider__akcii() {
    var owl1 = $('.loop-test');
    var owl2 = $('.loop-test2');
    owl1.owlCarousel({
        items:1,
        // loop:true,
        dots: true,
        autoHeight: true,
        nav: true,
        item: 1,
        navText: ["", ""],
        animateIn: 'fadeInLeft',
        animateOut: 'fadeOutLeft',
        asNavFor: '.loop-test2',
        mouseDrag: false,
        touchDrag: false
    });
    owl2.owlCarousel({
        items:1,
        // loop:true,
        autoHeight: true,
        nav: false,
        item: 1,
        navText: ["", ""],
        dots: false,
        asNavFor: ".loop-test",
        animateIn: 'fadeInRight',
        animateOut: 'fadeOutRight',
        mouseDrag: false,
        touchDrag: false
    });
    owl1.on('click', '.owl-next', function () {
        owl2.trigger('next.owl.carousel')
    });
    owl1.on('click', '.owl-prev', function () {
        owl2.trigger('prev.owl.carousel')
    });
    owl1.on('click', '.owl-dot', function () {
        owl2.trigger('next.owl.carousel')
    });
    owl1.on('click', '.owl-dot', function () {
        owl2.trigger('prev.owl.carousel')
    });
}