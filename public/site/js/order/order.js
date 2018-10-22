$(document).ready(function () {
    $.validator.setDefaults({
        ignore: []
    });
    click__check();
    validate__track();
    datepicker();
    file__text();
    change__line();
    datepircker3();
    lang__date();
    click__date()
});
// После отправки формы всплывает попап #order__shop
function click__check() {
    $(".registr__check-inp").click(function () {
        $('.registr__check').toggleClass('registr__check-before');
    });
}

function validate__track() {
        $('.track__form-js').validate({
            rules: {
                name__shop: {
                    required: true,
                },
                "name__goods[0]": {
                    required: true,
                },
                "link__goods[0]": {
                    required: true,
                },
                name__goods: {
                    required: true,
                },
                link__shop: {
                    required : true
                },
                number__order: {
                    required : true
                },

                terms: {
                    required : true
                },
                goods__delivery:{
                    required:true
                },
                goods__delivery1:{
                    required:true
                },
                goods__order:{
                    required:true
                },
                price__order:{
                    required:true

                },
                link__goods:{
                    required:true
                },
                price__cart:{
                    required:true
                },
                category__shop:{
                    required:true
                },
                discount__h:{
                    required:true
                },
                size__discount:{
                    required:true
                },
                file:{
                    required:true,
                    accept: "image/*,video/*"
                },
                "date[]":{
                    required:true
                },
                discount__order:{
                    required:true
                },
                discount__some:{
                    required:true,
                    number: true
                },
                disc__size:{
                    required:true
                },
                price__delivery:{
                    required:true
                },
                'goods__on[0]':{
                    required:true
                },
                'quantity[0]':{
                    required:true
                },
                order__point:{
                    required:true
                },
                treck__number:{
                    required:true
                },
                "track__number[]":{
                    required:true
                }
            },
            messages: {
                price__delivery:{
                  number:'Введите корректное число',
                    required: 'Обязательный параметр'
                },
                name__shop: {
                    required: 'Обязательный параметр'
                },
                'quantity[0]':{
                    required: 'Обязательный параметр'
                },
                "name__goods[]": {
                    required: 'Обязательный параметр'
                },
                "name__goods[0]": {
                    required: 'Обязательный параметр'
                },
                "link__goods[0]": {
                    required: true,
                },
                name__goods: {
                    required: 'Обязательный параметр'
                },
                link__shop: {
                    required : 'Обязательный параметр'
                },
                number__order: {
                    required : 'Обязательный параметр'
                },
                goods__delivery:{
                    required:'Обязательный параметр'
                },
                goods__delivery1:{
                    required:'Обязательный параметр'
                },
                goods__order:{
                    required:'Обязательный параметр'
                },
                price__order:{
                    required:'Обязательный параметр',
                    number:'Введите корректное число'
                },
                link__goods:{
                    required:'Обязательный параметр'
                },
                price__cart:{
                    required:'Обязательный параметр'
                },
                category__shop:{
                    required:'Обязательный параметр'
                },
                discount__h:{
                    required:'Обязательный параметр'
                },
                size__discount:{
                    required:'Обязательный параметр'
                },
                file:{
                    required:'Обязательный параметр'
                },
                "date[]":{
                    required:'Обязательный параметр'
                },
                discount__order:{
                    required:'Обязательный параметр'
                },
                discount__some:{
                    required:'Обязательный параметр',
                    number:'Введите корректное число'
                },
                disc__size:{
                    required:'Обязательный параметр'
                },
                terms: {
                    required:'Обязательный параметр'
                },
               'goods__on[0]': {
                    required:'Обязательный параметр'
                },
                order__point:{
                    required:'Обязательный параметр'
                },
                "track__number[]": {
                    required : 'Обязательный параметр'
                },
                treck__number: {
                    required : 'Обязательный параметр'
                }
            }
        })
}
function file__text() {
    $(".file-upload input[type=file]").change(function(){

        var filename = $(this).val().replace(/.*\\/, "");
        $("#filename").val(filename);
        $('.file__close').show();
    });
    $('.file__close').click(function () {
        $("#filename").val('');
        $(".file-upload input[type=file]").val('');
        $('.file__close').hide();
    });
}
function datepicker() {
    $( ".datepicker" ).datepicker({
        dateFormat: "dd.mm.yy",
        ignoreReadonly: true,
        allowInputToggle: true,
        changeMonth: true,
        changeYear: true
    }).on('change', function() {
        $(this).valid();
    });
}
function datepircker3() {
    $(".datepicker2").datepicker({
        dateFormat: "dd.mm.yy",
        numberOfMonths: 2,
        buttonText: "Select date",
        ignoreReadonly: true,
        rangeSelect: true,
        onSelect: function( selectedDate ) {
            if(!$(this).data().datepicker.first){
                $(this).data().datepicker.inline = true;
                $(this).data().datepicker.first = selectedDate;
            }else{
                if(selectedDate > $(this).data().datepicker.first){
                    $(this).val($(this).data().datepicker.first+" - "+selectedDate);
                }else{
                    $(this).val(selectedDate+" - "+$(this).data().datepicker.first);
                }
                $(this).data().datepicker.inline = false;
            }
        },
        onClose:function(){
            delete $(this).data().datepicker.first;
            $(this).data().datepicker.inline = false;
        }
    }).on('change', function() {
        $(this).valid();
    });
}
function change__line() {
        var block1 = $(".discount__block1");
        var block2 = $(".discount__block2");
        var block3 = $(".discount__block3");
        $('.change__line').change(function () {
            if ($(this).val() === '2') {
                block1.hide();
                block1.find('input').removeAttr('name');
                block2.show();
                block2.find('input').attr('name','discount__some');
                block2.find('select').attr('name','track__number[]');
                block3.hide();
                block3.find('input').removeAttr('name');
                validator__add = new validate__track();
            }
            if ($(this).val() === '3') {
                block1.show();
                block1.find('input').attr('name','date[]');
                date3 = new datepircker3();
                block2.hide();
                block2.find('input').removeAttr('name');
                block2.find('select').removeAttr('name');
                block3.hide();
                block3.find('input').removeAttr('name');
                validator__add = new validate__track();
            }
            if ($(this).val() === '4') {
                block3.show();
                block3.find('input').attr('name','date[]');
                date4 = new datepircker3();
                block1.hide();
                block1.find('input').removeAttr('name');
                block2.hide();
                block2.find('input').removeAttr('name');
                block2.find('select').removeAttr('name');
                validator__add = new validate__track();
            }
        });
    };

function lang__date() {
    ( function( factory ) {
        if ( typeof define === "function" && define.amd ) {

            // AMD. Register as an anonymous module.
            define( [ "../widgets/datepicker" ], factory );
        } else {

            // Browser globals
            factory( jQuery.datepicker );
        }
    }( function( datepicker ) {

        datepicker.regional.ru = {
            closeText: "Закрыть",
            prevText: "&#x3C;Пред",
            nextText: "След&#x3E;",
            currentText: "Сегодня",
            monthNames: [ "Январь","Февраль","Март","Апрель","Май","Июнь",
                "Июль","Август","Сентябрь","Октябрь","Ноябрь","Декабрь" ],
            monthNamesShort: [ "Янв","Фев","Мар","Апр","Май","Июн",
                "Июл","Авг","Сен","Окт","Ноя","Дек" ],
            dayNames: [ "воскресенье","понедельник","вторник","среда","четверг","пятница","суббота" ],
            dayNamesShort: [ "вск","пнд","втр","срд","чтв","птн","сбт" ],
            dayNamesMin: [ "Вс","Пн","Вт","Ср","Чт","Пт","Сб" ],
            weekHeader: "Нед",
            dateFormat: "dd.mm.yy",
            firstDay: 1,
            isRTL: false,
            showMonthAfterYear: false,
            yearSuffix: "" };
        datepicker.setDefaults( datepicker.regional.ru );

        return datepicker.regional.ru;

    } ) );
}
function click__date() {
    var w = $(window).width();
    if (w < 767) {
        $(".datepicker2").click(function () {
            // $('html,body').animate({scrollTop: 350}, 500);
            $("html, body").animate({ scrollTop: $('.offset__date').offset().top }, 500);
            // $(this).addClass('sdfsd');
        })
    }
}

