<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SuperUser | Art-Sites.org</title>

    <!-- Bootstrap Core CSS -->
    <link href="/admin/css/bootstrap.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/admin/css/sb-admin.css" rel="stylesheet">
    <link href="/admin/css/back.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="/admin/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">


    <!-- jQuery -->
    <script src="/admin/js/jquery.js"></script>

    <link href="/admin/plugins/summernote/summernote.css" rel="stylesheet">
    <script src="/admin/plugins/summernote/summernote.js"></script>


    <link href="/admin/plugins/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
          type="text/css"/>
    <!-- the main fileinput plugin file -->
    <script src="/admin/plugins/bootstrap-fileinput/js/fileinput.js"></script>
    <script src="/admin/plugins/bootstrap-fileinput/js/plugins/sortable.min.js"></script>

    <link href="/admin/plugins/chosen/chosen.css" rel="stylesheet">
    <script src="/admin/plugins/chosen/chosen.jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script type="text/javascript" src="/admin/plugins/moment/min/moment.min.js"></script>
    <script type="text/javascript" src="/admin/plugins/moment/min/locales.min.js"></script>
    <script src="/admin/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="/admin/plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js"></script>
    <link rel="stylesheet"
          href="/admin/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>

    <link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
    <script src="/admin/plugins/data-table/jquery.dataTables.min.js"></script>
    <script src="/admin/plugins/data-table/dataTables.buttons.min.js"></script>
    <script src="/admin/plugins/data-table/buttons.flash.min.js"></script>
    <script src="/admin/plugins/data-table/jszip.min.js"></script>
    <script src="/admin/plugins/data-table/pdfmake.min.js"></script>
    <script src="/admin/plugins/data-table/vfs_fonts.js"></script>
    <script src="/admin/plugins/data-table/buttons.html5.min.js"></script>
    <script src="/admin/plugins/data-table/buttons.print.min.js"></script>

    {{--back--}}
    <script src="/admin/plugins/data-table/jquery-ui.js"></script>
    {{--back--}}

    {{--galley--}}
    <link rel="stylesheet" href="/admin/plugins/fileupload/jquery.fileupload.css">
    <script src="/admin/plugins/fileupload/load-image.all.min.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload.js"></script>
    <script src="/admin/plugins/fileupload/tmpl.min.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload-process.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload-image.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload-audio.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload-video.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload-validate.js"></script>
    <script src="/admin/plugins/fileupload/jquery.fileupload-ui.js"></script>
    {{--galley--}}

    {{--FancyBox--}}
    <link rel="stylesheet" href="/admin/plugins/fancybox/jquery.fancybox.min.css">
    <script src="/admin/plugins/fancybox/jquery.fancybox.min.js"></script>
    {{--FancyBox--}}

    <script src="/admin/plugins/bootstrap-fileinput/js/locales/ru.js"></script>


    <script src="/admin/js/back/main.js"></script>
    <script src="/admin/js/back/chosen.js"></script>
    <script src="/admin/js/back/fileInput.js"></script>
    <script src="/admin/js/back/summerNode.js"></script>
    <script src="/admin/js/back/repeater.js"></script>
    <script src="/admin/js/back/delimiter.js"></script>
    <script src="/admin/js/back/gallery.js"></script>
</head>

<body>

<div id="wrapper">
    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/superuser/">SuperUser | Art-Sites.org</a>
            <a href="/" target="_blank" type="submit" class="btn btn-primary" style=" margin-top: 8px;">Сайт</a>
        </div>
        @include('admin.template.sidebar')
    </nav>