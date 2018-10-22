$(function () {
    $('.fileImageInput').each(function () {
        new GalleryInput(this);
    });


});

function GalleryConstructor(galleryObject, usedInput) {
    var $class = this;

    this.galleryCheckBind = function () {
        $("#galleryForm .file .check, .galleryAdd").unbind('click');
        $('#galleryForm .file .check').click(function () {
            $(this).toggleClass('checked');
        });
        $('.galleryAdd').click(function () {
            var el = $('#galleryForm .file .check.checked');
            if (el.length > 0) {
                var data = [];
                var gallery = $(galleryObject).parent().find('.galleryInput');
                var max = parseInt(gallery.data('max'));
                var counter = gallery.find('>.img').length;
                el.each(function () {
                    if (counter >= max) return false;
                    gallery.append(tmpl('' +
                        '<div class="img" data-id="{%= o.id %}">\n' +
                        '            <img src="{%= o.img %}" alt="">\n' +
                        '            <div class="controls">\n' +
                        // '                <i class="edit fa fa-pencil"></i>\n' +
                        '                <i class="delete fa fa-times"></i>\n' +
                        '            </div>\n' +
                        '        </div>')({
                        id: $(this).data('id'),
                        img: $(this).parent().find('>img').attr('src')
                    }))
                    counter++;
                });
                usedInput.galleryOnPageBind();
            }
            $.fancybox.close(true);
            return false;
        })
    };

    this.galleryBind = function () {
        var gallery = $('#galleryForm');
        gallery.fileupload({
            url: '/superuser/upload/image/' + gallery.data('folder') + '/' + gallery.data('size'),
            dropzone: $('#galleryForm'),
            filesContainer: $('.file-list'),
            uploadTemplateId: false,
            downloadTemplateId: false,
            autoUpload: true,
            uploadTemplate: tmpl(
                '{% for (var i=0, file; file=o.files[i]; i++) { %}' +
                '<div class="file template-upload fade col-lg-2 col-md-4 col-sm-6 {%=file.type.search("image") !== -1? "image" : "other-file"%}">' +
                '<div class="file-item">' +
                '<div class="preview vertical-align">' +
                '<div class="file-action-wrap">' +
                '</div>' +
                '</div>' +
                '<div class="info-wrap">' +
                '<div class="title">{%=file.name%}</div>' +
                '</div>' +
                '<div class="progress progress-striped active" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" role="progressbar">' +
                '<div class="progress-bar progress-bar-success" style="width:0%;"></div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '{% } %}'
            ),
            downloadTemplate: tmpl(
                '{% for (var i=0, file; file=o.files[i]; i++) { %}' +
                '<div class="file template-download fade col-lg-2 col-md-4 col-sm-6 {%=file.type.search("image") !== -1? "image" : "other-file"%}">' +
                '<div class="file-item">' +
                '<div class="preview vertical-align">' +
                '<div class="check checked" data-id="{%=file.id%}"><div class="checkbox"><i class="fa fa-check-square" aria-hidden="true"></i></div></div>' +
                '<div class="file-action-wrap">' +
                '<div class="file-action">' +
                '<i class="icon delete fa fa-times" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"></i>' +
                '</div>' +
                '</div>' +
                '<img src="{%=file.url%}"/>' +
                '</div>' +
                '<div class="info-wrap">' +
                '<div class="title">{%=file.name%}</div>' +
                '</div>' +
                '</div>' +
                '</div>' +
                '{% } %}'
            ),
            forceResize: true,
            //previewCanvas: false,
            previewMaxWidth: false,
            previewMaxHeight: false,
            previewThumbnail: false
        }).on('fileuploadprocessalways', function (e, data) {
            var length = data.files.length;

            for (var i = 0; i < length; i++) {
                if (!data.files[i].type.match(/^image\/(gif|jpeg|png|svg\+xml)$/)) {
                    data.files[i].filetype = 'other-file';
                } else {
                    data.files[i].filetype = 'image';
                }
            }
        }).on('fileuploadadded', function (e) {
            var $this = $(e.target);

            if ($this.find('.file').length > 0) {
                $this.addClass('has-file');
            } else {
                $this.removeClass('has-file');
            }
        }).on('fileuploadfinished', function (e) {
            var $this = $(e.target);

            if ($this.find('.file').length > 0) {
                $this.addClass('has-file');
            } else {
                $this.removeClass('has-file');
            }
            $class.galleryCheckBind()
        }).on('fileuploaddestroyed', function (e) {
            var $this = $(e.target);

            if ($this.find('.file').length > 0) {
                $this.addClass('has-file');
            } else {
                $this.removeClass('has-file');
            }
        }).on('click', function (e) {
            if ($(e.target).parents('.file').length === 0) $('#inputUpload').trigger('click');
        });

        $(document).bind('dragover', function (e) {
            var dropZone = $('#galleryForm'),
                timeout = window.dropZoneTimeout;
            if (!timeout) {
                dropZone.addClass('in');
            } else {
                clearTimeout(timeout);
            }
            var found = false,
                node = e.target;
            do {
                if (node === dropZone[0]) {
                    found = true;
                    break;
                }
                node = node.parentNode;
            } while (node !== null);
            if (found) {
                dropZone.addClass('hover');
            } else {
                dropZone.removeClass('hover');
            }
            window.dropZoneTimeout = setTimeout(function () {
                window.dropZoneTimeout = null;
                dropZone.removeClass('in hover');
            }, 100);
        });

        $('#inputUpload').on('click', function (e) {
            e.stopPropagation();
        });

        $class.galleryCheckBind();
    };

    this.galleryBind();
}

function GalleryInput(domEl) {
    var $class = this;

    this.galleryOnPage = function () {
        $(domEl).find('.js-open_gallery').fancybox({
            afterShow: function (instance, slide) {
                new GalleryConstructor(slide.opts.$orig, $class);
            }
        });
        $(domEl).find('.galleryInput').sortable();
        $class.galleryOnPageBind();
    };
    this.galleryOnPageBind = function ($bindClass) {
        var deleteBtn = $(domEl).find('.galleryInput .img .delete');
        deleteBtn.unbind('click');
        deleteBtn.click(function () {
            $(this).parents('.img').remove();
        })
    };

    this.galleryOnPageBind();
    this.galleryOnPage();
}

function GallerySubmit(domGallery) {
    var ret = true;
    $(domGallery).each(function () {
        var img = $(this).find('.galleryInput .img');
        if ($(this).hasClass('imageRqui') && img.length == 0) {
            $(this).addClass('valid_error');
            ret = false;
            return false;
        } else {
            $(this).removeClass('valid_error');
        }

        var data = [];
        img.each(function () {
            data.push($(this).data('id'));
        });
        $(this).find('>input').val(JSON.stringify(data));
    });
    return ret;
}