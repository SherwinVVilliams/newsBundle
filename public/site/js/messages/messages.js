$(document).ready(function () {
    file__text();
    close__file();
});
function file__text() {
    $(".file-upload input[type=file]").change(function(){
        var filename = $(this).val().replace(/.*\\/, "");
        $(".file__change").val(filename).next().show();
        // $('.file__close').show();
        $(".filename").removeClass('file__change');
        $('.filename__lab').append('<span class="file__change-wrap">\n' +
            '<input type="text" class="filename file__change" disabled="">\n' +
            '<i class="file__close"><img src="img/main/block6/exit.svg" alt="img">\n' +
            '</i>\n' +
            '</span>');
        addFile = new close__file();
    });

}
function close__file() {
    $('.file__close').click(function () {
        $(this).parent('.file__change-wrap').remove();
        $(this).hide();
    });
}
