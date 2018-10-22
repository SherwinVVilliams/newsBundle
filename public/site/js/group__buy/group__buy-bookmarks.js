$(document).ready(function () {
    sendTabs();
    AOS.init({
        disable: 'mobile'
    });
    close_tab();
});

function sendTabs() {
    var nameX = $('.r-col .send_to_tabs');
    nameX.parents('.r-col').toggleClass('addTabsActive');
    nameX.parents('.r-col').toggleClass('active__tab__login');
    nameX.parents('.r-col').find('.close__tab').css('display', 'block');
    nameX.parents('.r-col').find('a').text('В закладках');
    nameX.click(function (e) {
        /* тут проверка если пользователь зареестрирован, если да то следующий код, если нет то папоп с входом на сайт    */
        e.preventDefault();
        $(this).parents('.r-col').toggleClass('addTabsActive');
        $(this).parents('.r-col').toggleClass('active__tab__login');
        $(this).parents('.r-col').find('.close__tab').css('display', 'block');
        $(this).parents('.r-col').find('a').text('В закладках');
    })
}
function close_tab() {
    $('.close__tab').click(function () {
        $(this).parents('.r-col').removeClass('addTabsActive').removeClass('active__tab__login');
        $(this).parents('.r-col').find('a').text('В закладки');
        $(this).parents('.r-col').find('.close__tab').css('display', 'none');

    })
}