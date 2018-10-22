function ChosenSubmit(chosen) {
    chosen.each(function () {
        var obj = $(this).find("*").serializeArray();
        var str = "";
        var name = $(this).find("select").attr("name");
        for (var o in obj) {
            str += obj[o].value + ","
        }
        $(this).empty();
        $(this).append("<input name='" + name + "' type='hidden' value='" + str + "'>");
    })
}

function ChosenValid() {
    var ret = true;
    $('.chosen.require').each(function () {
        if ($(this).find('.chosen-choices .search-choice').length == 0 ) {
            ret = false;
            $(this).find('.chosen-choices').css('border', '2px solid red');
            $('.main_form_require').show();
        }
    });
    return ret;
}
