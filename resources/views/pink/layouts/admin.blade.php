<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset(config('settings.theme')) }}/admin/assets/images/favicon.png">

    <title>{{ $title ? $title : 'Admin' }}</title>

    <!-- Custom CSS -->
    <link href="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/css/float-chart.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme')) }}/admin/assets/libs/select2/dist/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset(config('settings.theme')) }}/admin/assets/libs/bootstrap-select/dist/css/bootstrap-select.min.css">
    <!-- Custom CSS -->
    <link href="{{ asset(config('settings.theme')) }}/admin/dist/css/style.min.css" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/jquery/dist/jquery.min.js"></script>
</head>

<body>
<!-- ============================================================== -->
<!-- Preloader - style you can find in spinners.css -->
<!-- ============================================================== -->
<div class="preloader">
    <div class="lds-ripple">
        <div class="lds-pos"></div>
        <div class="lds-pos"></div>
    </div>
</div>
<!-- ============================================================== -->
<!-- Main wrapper - style you can find in pages.scss -->
<!-- ============================================================== -->
<div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <header class="topbar" data-navbarbg="skin5">
        @yield('admin.header')
    </header>
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <aside class="left-sidebar" data-sidebarbg="skin5">
        <!-- Sidebar scroll-->
            @yield('admin.sideBar')
        <!-- End Sidebar scroll-->
    </aside>
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Page wrapper  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
        <!-- ============================================================== -->
        <!-- Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->

        <div class="page-breadcrumb">
            <div class="row">
                <div class="col-12 d-flex no-block align-items-center">
                    <h4 class="page-title">{{ $title }}</h4>
                    <div class="ml-auto text-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @for($i = 1; $i <= count(Request::segments()); $i++)

                                    <li class="breadcrumb-item">
                                        <a href="">{{ \Str::title(Request::segment($i)) }}</a>
                                    </li>
                                @endfor

                                {{--<li class="breadcrumb-item active" aria-current="page">Library</li>--}}
                            </ol>

                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Bread crumb and right sidebar toggle -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Container fluid  -->
        <!-- ============================================================== -->
        <div class="container-fluid">

            @if (session('status'))
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-success" role="alert">
                            <div class="row">
                                <div class="col-1">
                                    <h1 class="font-light text-green">
                                        <i class="mdi mdi-check"></i>
                                    </h1>
                                </div>
                                <div class="col-11">
                                    <p>{{ session('status') }}</p>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endif

            @if (count($errors) > 0)
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger" role="alert">
                            <div class="row">
                                <div class="col-1">
                                    <h1 class="font-light text-red d-inline">
                                        <i class="mdi mdi-close-outline"></i>
                                    </h1>
                                </div>
                                <div class="col-11">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @yield('admin.content')
        </div>
        <!-- ============================================================== -->
        <!-- End Container fluid  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- footer -->
        <!-- ============================================================== -->
        <footer class="footer text-center">
            @yield('admin.footer')
        </footer>
        <!-- ============================================================== -->
        <!-- End footer -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
</div>
<!-- ============================================================== -->
<!-- End Wrapper -->
<!-- ============================================================== -->
<!-- ============================================================== -->
<!-- All Jquery -->
<!-- ============================================================== -->

<!-- Bootstrap tether Core JavaScript -->
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/bootstrap-select/dist/js/bootstrap-select.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/extra-libs/sparkline/sparkline.js"></script>
<!--Wave Effects -->
<script src="{{ asset(config('settings.theme')) }}/admin/dist/js/waves.js"></script>
<!--Menu sidebar -->
<script src="{{ asset(config('settings.theme')) }}/admin/dist/js/sidebarmenu.js"></script>
<!--Custom JavaScript -->
<script src="{{ asset(config('settings.theme')) }}/admin/dist/js/custom.min.js"></script>
<!--This page JavaScript -->
<!-- <script src="{{ asset(config('settings.theme')) }}/admin/dist/js/pages/dashboards/dashboard1.js"></script> -->
<!-- Charts js Files -->
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/excanvas.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/jquery.flot.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/jquery.flot.pie.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/jquery.flot.time.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/jquery.flot.stack.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot/jquery.flot.crosshair.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/flot.tooltip/js/jquery.flot.tooltip.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/dist/js/pages/chart/chart-page-init.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/select2/dist/js/select2.full.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/select2/dist/js/select2.min.js"></script>
<script src="{{ asset(config('settings.theme')) }}/admin/assets/libs/ckeditor/ckeditor.js"></script>



<script>
    $(".select2").select2();



</script>

</body>

</html>