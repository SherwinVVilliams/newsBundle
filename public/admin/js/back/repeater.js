function RepeaterConstructor(id, min, max) {
    this.id = id;
    this.min = min;
    this.max = max;
    var $class = this;
    var r = {};

    this.create = function () {
        min = parseInt(min);
        max = parseInt(max);
        var template = $(id).find(".template").html();
        $(id).find(".template").empty();

        var i = $(id).find(".body").data("i");
        if (i && i.length > 0) {
            for (var a in i) {
                $class.addOne($(id), i[a], template)
            }
        }

        if ((!i && min) || (i && min > i.length)) {
            min = i && min > i.length ? min - i.length : min;
            for (var j = min; j--;)
                $class.addOne($(id), false, template);
        }


        $(id).find(".add").click(function () {
            if (max && $(id).find('.item').length >= max) return false;
            $class.addOne($(this).parent(), false, template)
            $class.buttons();
        });

        this.buttons();
        this.order();
    };

    this.addOne = function (its, data, template) {
        var n = its.data("name");
        if (!r[n]) {
            r[n] = its.find(".body > div").length;
        }
        r[n]++;
        its.find(".body").append("<div class='item  item" + r[n] + "'>" + template + "</div>");
        var imps = its.find(".body .item" + r[n] + " *[name]");
        imps.each(function () {
            if (data) {
                if ($(this).attr("type") == 'checkbox') {
                    $(this).prop('checked', data[$(this).attr("name")] == 'on')
                } else if ($(this)[0].tagName == "SELECT") {
                    $(this).val(parseInt(data[$(this).attr("name")]));
                } else if ($(this).parents('.fileImageInput').length > 0) {
                    for (var a in data[$(this).attr("name")]) {
                        $(this).parents('.fileImageInput').find('.galleryInput').append(data[$(this).attr("name")][a])
                    }
                } else {
                    $(this).val(data[$(this).attr("name")]);
                }
            }

            if ($(this).parents('.fileImageInput').length > 0) {
                new GalleryInput($(this).parents('.fileImageInput')[0]);
            }

            if ($(this).parents('.chosen').length > 0) {
                $(this).chosen({max_selected_options: $(this).parents('.chosen').data('max')});
            }

            if ($(this).hasClass('datetimepicker')) {
                $(this).datetimepicker({
                    locale: 'ru',
                    format: $(this).data('format')
                });
                if (data && data[$(this).attr("name")] && $(this).hasClass('withtimestamp')) {
                    var time = data[$(this).attr("name")];
                    time = moment(parseInt(time) * 1000).format($(this).data('format'));
                    $(this).val(time);
                }
            }

            var attr = $(this).attr("name") + "[" + r[n] + "]";
            var simple = $(this).attr("name");
            $(this).attr("name", attr);

            if ($(this).parents('.summenrInstall').length > 0) {
                summenrInstall(attr, simple, its.selector);
            }
        });


        imps.each(function () {
            if ($(this).hasClass("fileInput")) {
                fileInput(
                    $(this).data("name") + "[" + r[n] + "]",
                    $(this).data("width"),
                    $(this).data("height"),
                    $(this).data("max"),
                    (data && data[$(this).data("name")] ? (data[$(this).data("name")] == '[false]' ? '' : data[$(this).data("name")]) : "")
                )
            }
        });
        if (!data) its.find(".body .item" + r[n] + " input[name^=num]").val(r[n]);
        $class.deleteBind(its.find(".body .item" + r[n] + " .delete"));
    };

    this.deleteBind = function (selector) {
        selector.click(function () {
            if (min && $(id).find('.item').length <= min) return false;

            $(this).parents(".item").remove();
            $class.buttons();
        })
    };

    this.order = function () {
        $(this.id).find('.body').sortable({
            handle: "label",
            axis: 'y'
        });
        //$(this.id).find('*').not('.summenrInstall').disableSelection();
    };

    this.buttons = function () {
        if (min && $(id).find('.item').length <= min) {
            $(id).find('.delete').hide();
        } else {
            $(id).find('.delete').show();
        }

        if (max && $(id).find('.item').length >= max) {
            $(id).find('.add').hide();
        } else {
            $(id).find('.add').show();
        }
    }
}


function RepeaterSubmit(rep) {
    rep.each(function () {
        var items = [];
        $(this).find(".template").empty();
        $(this).find(".item").each(function () {
            var array = $(this).find(":input").serializeArray();
            if ($(this).find(".summenrInstall").length > 0) {
                $(this).find(".summenrInstall").each(function () {
                    $(this).find(" > textarea").each(function (i) {
                        //console.log($(this).parent().find(" > div").not('.note-editor').eq(i).summernote('code'));
                        array.push({
                            name: $(this).attr("name"),
                            value: $(this).parent().find(" > div").not('.note-editor').eq(i).summernote('code').replace(/\&quot\;/g, "'"),
                        });
                    });
                    //debugger;

                });

            }
            var obj = {};
            for (var a in array) {
                obj[array[a]["name"].split("[")[0]] = array[a]["value"];
            }
            items.push(obj);
        });
        var data = JSON.stringify(items);
        $(this).empty();
        $(this).append("<textarea name='" + $(this).data("name") + "'>" + data + "</textarea>")
    })
}
