'use strict'
$(document).ready(function () {
    Count__dropdown();
    dataTable();

});
function Count__dropdown() {
    var dropdown = $('.counting__dropdown a');
    var dropdown1 = $('.counting__topay a');
    dropdown.addClass('dropdown__js');
    dropdown1.addClass('dropdown__js');
    dropdown.click(function (e) {
       e.preventDefault();
        $('.counting__topay a').toggle();
        $('.counting__balance-hide').toggle();
       $('.table__dropdown').slideToggle(200);
        if(dropdown.hasClass('dropdown__js')){
            $(this).removeClass('dropdown__js').html('Свернуть');
            $('.counting__plus').hide();
            $('.counting__minus').show();
        }
        else{
            $(this).addClass('dropdown__js').html('Развернуть');
            $('.counting__plus').show();
            $('.counting__minus').hide();
        }
    });
    dropdown1.click(function (e) {
        e.preventDefault();
        $('.counting__topay a').toggle();
        $('.counting__balance-hide').toggle();
        $('.table__dropdown').slideToggle(200);
        if(dropdown.hasClass('dropdown__js')){
            dropdown.removeClass('dropdown__js').html('Свернуть');
            $('.counting__plus').hide();
            $('.counting__minus').show();
        }
        else{
            dropdown.addClass('dropdown__js').html('Развернуть');
            $('.counting__plus').show();
            $('.counting__minus').hide();
        }
    });
};
function dataTable() {
    $('#table_id').DataTable({
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

