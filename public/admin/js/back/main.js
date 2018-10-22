$(function () {
    $(".deleteButton").click(function () {
        return confirm('Вы уверенны? Это действие нельзя отменить!');
    });
    submitForm();
    ListTable();
    save_interview();
});

function save_interview() {
    $('.save_interview').click(function () {
        var data = [$('.pdf_name').text()];
        $('.pdf_tab p').each(function () {
            data.push($(this).text().replace(':', ':\n'));
        });

        var csvContent = "data:text;charset=utf-8,\ufeff";

        var encodedUri = encodeURI(csvContent+data.join('\n\n'));
        var link = document.createElement("a");
        link.setAttribute("href", encodedUri);
        link.setAttribute("download", "my_data.txt");
        document.body.appendChild(link); // Required for FF

        link.click();
    })
}



function ListTable() {
    $('.table-responsive table').not('.exportTable').DataTable({
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json"
        }
    });
    $('.exportTable').DataTable({
        "order": [],
        dom: 'Bfrtip',
        buttons: ['excelHtml5', 'pdf', 'print'],
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.12/i18n/Russian.json"
        }
    });
}


function submitForm() {
    if ($('.mainSaveForm').length > 0) {
        $('.saveButton').show().click(function () {
            $('.mainSaveForm').find('[type="submit"]').trigger('click');
        });
    }

    $(".mainSaveForm input, .mainSaveForm textarea").on("invalid", function () {
        $('.main_form_require').show();
    });


    $("form").submit(function () {
        if (!ChosenValid()) {
            return false;
        }

        var gallery = $(this).find(".fileImageInput");
        if (gallery.length > 0) {
            if (!GallerySubmit(gallery)) {
                $('.main_form_require').show();
                return false;
            }
        }

        var chosen = $(this).find(".chosen");
        if (chosen.length > 0) {
            ChosenSubmit(chosen);
        }

        var rep = $(this).find(".repeater");
        if (rep.length > 0) {
            RepeaterSubmit(rep)
        }


    })
}


function IsJsonString(str) {
    try {
        JSON.parse(str);
    } catch (e) {
        return false;
    }
    return true;
}

