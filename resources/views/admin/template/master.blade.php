@include('admin.template.head')

<div id="page-wrapper">

    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">
                    @yield('pageName', 'Master')
                    <small>@yield('pageSubName', '')</small>
                    <span style="color:red; display: none;;font-size: 17px;" class="main_form_require">Не все обязательные поля заполнены</span>


                    <button type="submit" class="btn btn-primary saveButton">Отправить</button>
                </h1>
                <div class="navbar navbar-default" style="display: none;">
                    <div class="navbar-collapse collapse">
                        <ul class="nav navbar-nav">
                        </ul>
                    </div>
                    <!--/.nav-collapse -->
                </div>
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

@include('admin.template.footer')