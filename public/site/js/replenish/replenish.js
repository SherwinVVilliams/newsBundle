$(document).ready(function () {

    $('.replenish__form form').validate({
        rules:{
            summa__rub:{
                required: true
            }
        },
        messages:{
            summa__rub:{
                required:'Введите сумму в рублях',
                number:'Введите корректное число'
            }
        }
    })
});