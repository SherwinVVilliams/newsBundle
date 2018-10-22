'use strict';

$(function () {
     SelectCity();
    mask_Phone();
    profile__validate();
    Form__password();
    btn__noActive();
    eye__check();
    SelectRegion();
});
 function SelectCity() {
     $( function() {
         var availableTags = [
             "Москва",
             "Уфа",
             "Санкт-Петербург",
             "Иркутск",
             "Владивосток",
             "Калининград",
             "Астрахань"

         ];

         $("#tags").autocomplete({
             source: availableTags,
             open: function(event, ui) {
                 $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
             }
         });

     });

} ;

 function SelectRegion() {
     var regionTags=[
         'Алтайский край',
         'Амурская область',
         'Архангельская область',
         'Астраханская область',
         'Белгородская область',
         'Брянская область',
         'Владимирская область',
         'Волгоградская область',
         'Вологодская область',
         'Воронежская область',
         'Забайкальский край',
         'Ивановская область',
         'Иркутская область',
         'Тула'
     ];
     $("#profile__region").autocomplete({
         source: regionTags,
         open: function(event, ui) {
             $('.ui-autocomplete').off('menufocus hover mouseover mouseenter');
         }
     });
 }
function mask_Phone(){
    $(".maskPhone").mask("8(999) 999-9999");
}

function profile__validate(){
    $('.profile__data').validate({
        rules: {
            email: {
                required: true,
                regex :/^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/
            },
            name:{
                required: true
            },
            surname:{
                required: true
            },
            city:{
                required: true
            },
            region:{
                required: true,
            },
            street:{
                required: true,
            },
            house:{
                required: true,
            },
            index:{
                required: true
            },
            phone: {
                required: true,
                regex: /^([\(\)\+\- ]{0,2}[\d]){3,50}$/g
            },
        },
        messages: {
            name: {
                required: "Заполните поле\n"
            },
            region: {
                required: "Заполните поле\n"
            },
            surname: {
                required: "Заполните поле\n"
            },
            index: {
                required: "Заполните поле\n",
                number:"Введите корректное число"
            },
            house: {
                required: "Заполните поле\n"
            },
            street: {
                required: "Заполните поле\n"
            },
            city: {
                required: "Заполните поле\n"
            },
            email: {
                email: "Введите корректный электронный адрес",
                required: "Заполните поле"
            },
            phone: {
                required: "Заполните поле\n",
                regex: 'Введите корректный телефон'
            },
        }
    });
}
function Form__password(){
    $('.profile__password').validate({
        rules:{
            password : {
                required:true
            },
            password2 : {
                required:true
            },
            password__check : {
                equalTo : '[name="password2"]',
                required:true
            }
        },
        messages:{
            password : {
                required: "Заполните поле\n"
            },
            password2 : {
                required: "Заполните поле\n",
                equalTo:"Подтверджение пароля неверно"
            },
            password__check : {
                required: "Заполните поле\n",
                equalTo:"Подтверджение пароля неверно"
            }
        }
    }) // после смены пароля , вылазит попап (id="js__change-pass")
}

function btn__noActive() {
    $('#pass__change').change(function () {
        $('.infouser__button-password2').removeClass('button__no-active');
    })
}
function eye__check() {
    $('.password__eye').click(function () {

        var x = $(this).siblings('.infouser__inp-wrap').find('input');
        if (x.attr("type") === "password") {
            x.attr("type", "text");
        }
        else {
            x.attr("type", "password");
        }

    });
}


