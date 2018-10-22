function summerInstall(name, simple, repeater) {
    //console.log(repeater);
    repeater = repeater ? repeater : '';
    var el = $(repeater + " textarea[name='" + name + "']").parents('.summerInstall').find('>div.summer_' + simple + '');
    el.summernote({
        height: 300,
        toolbar: [
            //['groupname', ['button list']]
            ['style', ['style', 'bold', 'italic', 'underline', 'clear']],
            ['font', ['strikethrough', 'superscript', 'subscript']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['codeview']]
        ],
        callbacks: {
            onImageUpload: function (files) {
                sendFile(files[0], el);
            },
            onMediaDelete: function ($target, editor, $editable) {
                var key = $($target[0]).data('id');
                $.ajax({
                    data: {key: key},
                    type: "DELETE",
                    url: "/superuser/upload/delete",
                    success: function (data) {
                        console.log(data);
                    }
                });

                // remove element in editor
                $target.remove();
            }
        }

    });
    el.summernote('code', $(repeater + " textarea[name='" + name + "']").val());
    el.parents("form").submit(function () {
        $(repeater + " textarea[name='" + name + "']").val(el.summernote('code').replace(/&quot;/g, "'"));
    })
}

function sendFile(file, editor) {
    data = new FormData();
    data.append("file", file);
    $.ajax({
        data: data,
        type: "POST",
        url: "/superuser/upload/image/wysiwyg/0?simple=1",
        cache: false,
        contentType: false,
        processData: false,
        success: function (url) {
            editor.summernote('insertNode', $('<img>').attr('src', JSON.parse(url).files[0].url).attr('data-id', JSON.parse(url).files[0].id)[0]);
        }
    });
}