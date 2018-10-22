function fileInput(name, width, height, max, data) {
    var inp = $("input[name='fileI" + name + "']");
    var options = {
        language: 'ru',
        uploadUrl: "/superuser/upload/image/" + width + "/" + height + "", // server upload action
        uploadAsync: true,
        maxFileCount: max,
        validateInitialCount: true,
        initialPreviewShowDelete: true,
        initialPreviewFileType: 'image',
        initialPreview: [],
        initialPreviewAsData: false,
        initialPreviewConfig: [],
        allowedFileExtensions: ['jpg', 'png'],
        overwriteInitial: false
    };
    if (data) {
        try {
            var jso = JSON.parse(data);
            for (var a in jso) {
                options.initialPreview.push('<img src="/image/'+jso[a][0]+'" class="file-preview-image" alt="'+jso[a][1]+'" title="'+(jso[a][2] ? jso[a][2] : '')+'">');
                options.initialPreviewConfig.push({caption: jso[a][0], width: "120px", url: "/superuser/upload/delete", key: jso[a][0]})
            }
        } catch (e) {
            options.initialPreview = [
                '<img src="/image/'+data+'" class="file-preview-image" alt="">'
            ];
            options.initialPreviewFileType = 'image';
            options.initialPreviewConfig = [
                {width: "120px", url: "/superuser/upload/delete", key: data}
            ];
        }
    }

    inp.fileinput(options);
    fileAddAltInput(inp);
    inp.on("filebatchselected", function () {
        inp.fileinput("upload");
    });
    inp.on('filebatchuploadcomplete', function(event) {
        console.log("change");
        fileAddAltInput(inp);
    });
}

function fileInputSubmit(img) {
    var ret = true;
    img.each(function () {
        var data = [];
        $($(this).find('input[type=file]').fileinput('getFrames')).each(function () {
            data.push([$(this).find('.file-footer-caption').text().trim(), $(this).find('input').eq(1).val(), $(this).find('input').eq(0).val()]);
        });
        $(this).find('input[type=hidden]').val(JSON.stringify(data));
        if($(this).hasClass('imageRqui') && data.length === 0){
            ret = false;
            return false;
        }
    });
    return ret;
}

function fileAddAltInput(inp) {
    inp.parents('.file-input').find('.file-preview-thumbnails .file-preview-frame').each(function () {
        if($(this).find('input').length == 0){
            var alt = $(this).find('.kv-file-content img').attr('alt'),
                title = $(this).find('.kv-file-content img').attr('title'),
            footer = $(this).find('.file-thumbnail-footer .file-footer-caption');
            footer.after('<div><input type="text" placeholder="Alt" value="'+alt+'"></div>');
            footer.after('<div><input type="text" placeholder="Title" value="'+title+'"></div>');
        }
    });
}