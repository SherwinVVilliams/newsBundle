
'use strict'
$(document).ready(function () {
    dataTable();
});

function dataTable() {
    // $('#table_id').DataTable({
    //     paging: false,
    //     searching:false,
    //     "info":  false,
    //     ordering:false,
    //     responsive:true
    // });
    var table = $('#table_id').DataTable( {
        paging: false,
        searching:false,
        "info":  false,
        ordering:false,
        responsive: true
    } );

    table.on( 'responsive-resize', function ( e, datatable, columns ) {
        var count = columns.reduce( function (a,b) {
            return b === false ? a+1 : a;
        }, 0 );

        console.log( count +' column(s) are hidden' );
    } );
}