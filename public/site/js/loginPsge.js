$(function () {
    StepLoginController();

});

function  StepLoginController() {
    Validate();
    nextStep = new ClickNext();
    firstStep = new StepOne();
    secondStep = new StepTwo();
    secondThree = new StepThree();


}
function Validate() {
    var form = $('.outmoney__form');
    form.validate({
        rules:{
            outmoney__rub: {
                required:true
            },
            money__exit: {
                required:true
            },
            requisites:{
                required:true
            }
        },
        messages:{
            outmoney__rub:{
                required:'Введите сумму в рублях',
                number:"Введите корректное число"
            },
            money__exit:{
                required:'Выберите систему для вывода'
            },
            requisites:{
                required:"Заполните поле"
            }
        },
        errorPlacement: function(error, element)
        {
            if ( element.is(":radio") )
            {
                error.appendTo( element.parents('.outmoney__tbody') );
            }
            else
            { // This is the default behavior
                error.insertAfter( element );
            }
        }
    })
}
function ClickNext() {
    this.submit = function () {
        var button__next = $('.outmoney__button-next');
        button__next.click(function (e) {
            e.preventDefault();
            if(!$(".step__first  :valid").valid()) return false;
            if ($(".step__second").is(":visible")) {
                if(!$(".step__second  :valid").valid()) return false;
            }
            $(this).parents('.step').removeClass('active').next().addClass('active');
            $('html, body').animate({scrollTop: 0}, 500);
        });
    };
   this.submit();
}

function ClickPrev(){
    var button__prev = $('.outmoney__button-prev');
    button__prev.click(function (e) {
        e.preventDefault();
        $(this).parents('.step').removeClass('active').prev().addClass('active');
    });
}
function StepOne() {
    var instance = this;


}

function StepTwo() {

    nextStep = new ClickPrev();
}
function StepThree() {
    nextStep = new ClickPrev();
}

// послу отправки формы попап #order__moneyOut

