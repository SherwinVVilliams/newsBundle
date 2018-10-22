$(document).ready(function () {
   add__goods();
});

function add__goods() {
    // $('.add__goods-btn').click(function () {
    //     goods = new goods__code();
    //
    //     validate2 = new validate__track();
    //     $('select').styler();
    //     $('.order__goods').find('.order__goods-wrap').prev().find('.order__line-bot').hide();
    //     $('.goods__exit').click(function () {
    //         $(this).parents('.order__goods-wrap').detach();
    //     });
    // });




    _.templateSettings.variable = "element";
    var tpl = _.template($("#form_tpl").html());
    var counter = 1;
    $(".add__goods-btn").on("click", function (e) {

        e.preventDefault();
        var tplData = {
            i: counter
        };
        $(".order__goods").append(tpl(tplData));
        counter += 1;
        $('select').styler();
        $('.order__goods').find('.order__goods-wrap').prev().find('.order__line-bot').hide();
        $('.goods__exit').click(function () {
            $(this).parents('.order__goods-wrap').detach();
        });
        $('.work_emp_name').each(function () {
            $(this).rules("add", {
                required: true,
                messages:{
                    required: 'Обязательный параметр'
                }
            })
        });
        $('.work_emp_link').each(function () {
            $(this).rules("add", {
                required: true,
                messages:{
                    required: 'Обязательный параметр'
                }
            })
        });
        $('.add__goods-sel').each(function () {
            $(this).rules("add", {
                required: true,
                messages:{
                    required: 'Обязательный параметр'
                }
            })
        });
        $('.inp__add-quan').each(function () {
            $(this).rules("add", {
                required: true,
                messages:{
                    required: 'Обязательный параметр'
                }
            })
        });
    });
}