$(function () {
    hamburger();

})

function hamburger() {
    $(".checkbox-toggle").on("click", function () {
        if ($(this).is(":checked")) {
            $('.hamburger svg').addClass("header_menu_hamburger");
            $('.align-self-center').addClass("active-checkbox");
        }
        else {
            $('.hamburger svg').removeClass("header_menu_hamburger");
            $('.align-self-center').removeClass("active-checkbox");
        }
    })

}
