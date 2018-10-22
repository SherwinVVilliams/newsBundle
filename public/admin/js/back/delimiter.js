$(function () {
    var delim = $('.delimiter'), nav = $('.navbar-default');

    if(delim.length > 0) nav.show();
    var first = 'active';
    delim.each(function () {
        if(first === '')
            $(this).hide();

        nav.find('.navbar-nav').append("<li class='"+first+"'>" +
                "<a href='#' data-id='"+$(this).data('id')+"'>"+
                    $(this).data('name')
                +"</a>" +
            "</li>");

        first = '';
    });

    nav.find('.navbar-nav a').click(function () {
        delim.hide();
        $('.delimiter-id-'+$(this).data('id')).show();

        nav.find('.navbar-nav li').removeClass('active');
        $(this).parent().addClass('active');
        return false;
    })
})