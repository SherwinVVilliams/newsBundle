'use strict';
$(document).ready(function () {
    dataTable1();
    remove__row();
    address__check();
    validate__form();
    mask_Phone();
    dataTable2();
    close__position();
});
function mask_Phone(){
    $(".maskPhone").mask("8(999) 999-9999");
}
function dataTable1() {
    $('#table_id').DataTable({

        paging: false,
        searching:false,
        ordering:false,
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
        }
    });
}
function remove__row() {
    $('.table__closeRow').click(function () {
       $(this).parents('.counting__tr').remove();

    });
}
function close__position() {


                var w__window = $(window).width();
                var w__table = $('.counting__list').width();
                var w__td = $('.counting__table-number').width();
                var  w__right =w__table -  w__td -15;
                $('.table__closeRow').css({'right': -w__right} );

                if(w__window<521){
                    var  w__right =w__table -  w__td -55;
                    $('.table__closeRow').css({'right': -w__right} );
                }
    $(window).resize(function () {
        var w__window = $(window).width();
        var w__table = $('.counting__list').width();
        var w__td = $('.counting__table-number').width();
        var  w__right =w__table -  w__td -15;
        $('.table__closeRow').css({'right': -w__right} );

        if(w__window<521){
            var  w__right =w__table -  w__td -55;
            $('.table__closeRow').css({'right': -w__right} );
        }
    });


}

function address__check() {
    $('.packageCreate__ItemAddress').click(function () {
        $(this).addClass('active').siblings().removeClass('active');
    })
}
function validate__form() {
    $('.packageCreate__validate').validate({
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
            room:{
                required: true
            },

            phone: {
                required: true,
                regex: /^([\(\)\+\- ]{0,2}[\d]){3,50}$/g
            }
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
            room: {
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
function dataTable2() {
    $('#table_id2').DataTable({

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
                "targets": 3
            },
            { "orderable": false,
                "targets": 4
            }

        ]
    });

}