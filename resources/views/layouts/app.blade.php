<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Wallet Manager</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/AdminLTE.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/skin-blue.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/ionicons.min.css') }}" rel="stylesheet">

    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <!-- Main Header -->
            <header class="main-header">

                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><b>MN</b>LV</span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><b>Wallet</b>Manager</span>
                </a>

                <!-- Header Navbar -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account Menu -->
                            @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                            @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" aria-haspopup="true" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">

                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">

                    <!-- Sidebar Menu -->
                    <ul class="sidebar-menu" data-widget="tree">
                        <li class="header">HEADER</li>
                        <li class="treeview">
                            <a href="#">Người dùng<span></span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('information') }}">Thông tin cá nhân</a></li>
                                <li><a href="{{ route('users.change_password') }}">Đổi mật khẩu</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> Quản lý ví<span></span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('wallet.add') }}">Tạo ví</a></li>
                                <li><a href="{{ route('wallet.list') }}">Danh sách ví</a></li>
                                <li><a href="{{ route('wallet.exchange') }}">Chuyển tiền</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> Danh mục thu chi <span></span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('add_transaction') }}">Thêm danh mục</a></li>
                                <li><a href="{{ route('transaction.list') }}">Danh mục</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"> Quản lý giao dịch <span></span>
                                <span class="pull-right-container">
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="{{ route('exchange') }}">Thêm giao dịch</a></li>
                                <li><a href="{{ route('exchange.list') }}">Danh sách giao dịch</a></li>
                                <li><a href="{{ route('exchange.report') }}">Báo cáo</a></li>
                            </ul>
                        </li>
                    </ul>
                    <!-- /.sidebar-menu -->
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 3 -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
        <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
        <script src="{{ asset('js/app.js') }}"></script>
        <!-- Bootstrap 3.3.7 -->

        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte.min.js') }}"></script>

        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. -->
        @yield('js')
    </body>
</html>
