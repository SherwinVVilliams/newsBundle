'use strict'
$(document).ready(function () {
    $('.registr__bundlebox').validate({
        rules: {
            email: {
                required: true,
                regex :/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
            },
            terms: {
                required : true
            }
        },
        messages: {
            email:{
                email: "Введите корректный электронный адрес",
                required: "Заполните поле"
            },
            terms: {
                required: "Заполните поле"
            }
        }
    });
    $(".registr__check-inp").click(function () {
        $('.registr__check').toggleClass('registr__check-before');
    });


    // после отправки формы перенаправляет на страницу profile.php и попап (id="js__thank-registr")

});



