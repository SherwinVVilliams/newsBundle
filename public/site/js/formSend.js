$(function () {
    formsAllPages();
});


function formsAllPages() {
    var asoc = {
        // общие
        'val' : 'Заявка с формы',
        'name': 'Имя',
        'phone': 'Номер телефона',
        'email': 'Е-mail',
        'city':'Город доставки',
        'size':'вес',
        'length':'Длинна',
        'beam':'ширина',
        'level':'высота'

    };

    // var heandle = "/plugin/aSendForm/assets/handle.php",
    //  	  	mail = 'bender--95@mail.ru';
    var heandle = "/plugin/aSendForm/assets/handle.php";
    var vRules = {
        rules: {
            name: {
                required: true
            },
            email: {
                required: true,
                email: true
            },
            phone: {
                required: true,
                regex: /^([\(\)\+\- ]{0,2}[\d]){3,50}$/g
            },
            city: {
                required: true,
            },
            size: {
                required: true
            },
            length: {
                required: true,
            },
            level: {
                required: true,
            },
            beam: {
                required: true,
            }

        },

        messages: {
            name: {
                required: "Заполните поле"
            },
            email: {
                email: "Введите корректный электронный адрес",
                required: "Заполните поле"
            },
            phone: {
                required: "Заполните поле",
                regex: 'Введите корректный телефон'
            },
            city: {
                required: "Заполните поле",
            },
            size: {
                required: "Заполните поле",
                number:"Введите корректное число"
            },
            length: {
                required: "Заполните поле",
                number:"Введите корректное число"
            },
            level: {
                required: "Заполните поле",
                number:"Введите корректное число"
            },
            beam: {
                required: "Заполните поле",
                number:"Введите корректное число"
            }
        },
    };
    
    $("#js_answer form").aSendForm({
        goal: function () {
            // ga('send', 'event', 'knopka', 'zakazat');
            // yaCounter26593851.reachGoal('send');
        },
        postQuery: heandle,
        closeData: 113000,
        associations: asoc,
        answer: function(){
            $.fancybox.open({
                src  : '#js__thank',
            })
        },
        validateRuls: vRules,
        onSend : function(){
            $("#js_answer form")[0].reset();
            $.fancybox.close();

        },
        onClickForm: function () {
        }
    });

    $("#js_answer__rate form").aSendForm({
        goal: function () {
            // ga('send', 'event', 'knopka', 'zakazat');
            // yaCounter26593851.reachGoal('send');
        },
        postQuery: heandle,
        closeData: 113000,
        associations: asoc,
        answer: function(){
            $.fancybox.open({
                src  : '#js__thank',
            })
        },
        validateRuls: vRules,
        onSend : function(){
            $("#js_answer form")[0].reset();
            $.fancybox.close();

        },
        onClickForm: function () {
        }
    });

}

