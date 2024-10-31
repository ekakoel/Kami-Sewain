<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin - @yield('title')</title>
    <!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="icons/kami_sewain_30_x_30.png">
	<link rel="icon" type="image/png" sizes="32x32" href="icons/kami_sewain_30_x_30.png">
	<link rel="icon" type="image/png" sizes="16x16" href="icons/kami_sewain_30_x_30.png">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="@yield('description')" />
    <meta name="author" content="@yield('author')" />
    <link href="{{ asset('dashboard/css/styles.css') }}" rel="stylesheet" />
    <!-- Google Font -->
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    {{-- <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="/../lib/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="/../css/custom.css">
    {{-- DATA TABLE --}}
    <link rel="stylesheet" type="text/css" href="/../vendors/datatables/css/core.css">
    <link rel="stylesheet" type="text/css" href="/../vendors/datatables/css/icon-font.min.css">
    <link rel="stylesheet" type="text/css" href="/../vendors/datatables/css/dataTables.bootstrap4.min.css">
	<link rel="stylesheet" type="text/css" href="/../vendors/datatables/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="/../vendors/datatables/css/style.css">
    <link rel="stylesheet" type="text/css" href="/../vendors/jquery-asColorPicker/dist/css/asColorPicker.css">
</head>

<body>
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="{{ route('admin.home') }}">
            <div class="nav-logo">
                <img src="{{ asset('logo/logo-kami-sewain-caption-color.png') }}" alt="Logo Kami Sewain Color">
            </div>
        </a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-lg-0 text-light" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li><a class="btn btn-text" href="{{ route('admin.logout.perform') }}">Logout <i class="fa fa-sign-out" aria-hidden="true"></i></a></li>
        </ul>
    </nav>
    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Dashboard</div>
                        <a class="nav-link" href="{{ route('admin.home') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Statistics
                        </a>
                        <div class="sb-sidenav-menu-heading">Posts</div>
                        <a class="nav-link" href="{{ route('admin.portfolio') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-file-text-o" aria-hidden="true"></i></div>
                            Portfolio
                        </a>
                        <a class="nav-link" href="{{ route('admin.comments') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-commenting-o" aria-hidden="true"></i></div>
                            Comment
                            @php
                                $commentCount = \App\Models\BlogComment::where('status','Pending')->count(); // Hitung jumlah komentar
                            @endphp
                            @if($commentCount > 0)
                                <span class="badge bg-danger float-end">{{ $commentCount }}</span> <!-- Tampilkan badge jika ada komentar -->
                            @endif
                        </a>
                        <div class="sb-sidenav-menu-heading">Services</div>
                        <a class="nav-link" href="{{ route('admin.products') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
                            Product
                        </a>
                        <a class="nav-link" href="{{ route('admin.categories.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-th-large" aria-hidden="true"></i></div>
                            Category
                        </a>
                        <a class="nav-link" href="{{ route('admin.models.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-th-large" aria-hidden="true"></i></div>
                            Model
                        </a>
                        <a class="nav-link" href="{{ route('admin.materials.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-th-large" aria-hidden="true"></i></div>
                            Material
                        </a>
                        <a class="nav-link" href="{{ route('admin.colors.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-th-large" aria-hidden="true"></i></div>
                            Color
                        </a>
                        <div class="sb-sidenav-menu-heading">Promotions</div>
                        <a class="nav-link" href="{{ route('admin.promotions') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-cube" aria-hidden="true"></i></div>
                            Promo
                        </a>
                        <div class="sb-sidenav-menu-heading">Orders</div>
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
                            Orders
                            @php
                                $commentCount = \App\Models\Orders::where('status','Payment')->count(); // Hitung jumlah komentar
                            @endphp
                            @if($commentCount > 0)
                                <span class="badge bg-danger">{{ $commentCount }}</span> <!-- Tampilkan badge jika ada komentar -->
                            @endif
                        </a>
                        <div class="sb-sidenav-menu-heading">Contact</div>
                        <a class="nav-link" href="{{ route('admin.contacts') }}">
                            <div class="sb-nav-link-icon"><i class="fa fa-envelope" aria-hidden="true"></i></div>
                            Messages
                        </a>
                        <div class="sb-sidenav-menu-heading">Users</div>
                        <a class="nav-link" href="{{ route('admin.users.index') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-users"></i></div>
                            User Manager
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer text-light">
                    <div class="small">Logged in as:</div>
                    {{ auth('admin')->user()->username }}
                </div>
            </nav>
        </div>
        <div id="layoutSidenav_content">
            <main>
                @yield('main')
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Kami Sewain 2023</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/../vendors/datatables/scripts/core.js"></script>
	<script src="/../vendors/datatables/scripts/script.min.js"></script>
	<script src="/../vendors/datatables/scripts/process.js"></script>
	<script src="/../vendors/datatables/scripts/layout-settings.js"></script>

    <script src="/../vendors/datatables/js/jquery.dataTables.min.js"></script>
	<script src="/../vendors/datatables/js/dataTables.bootstrap4.min.js"></script>
	<script src="/../vendors/datatables/js/dataTables.responsive.min.js"></script>
	<script src="/../vendors/datatables/js/responsive.bootstrap4.min.js"></script>
	<!-- buttons for Export datatable -->
	<script src="/../vendors/datatables/js/dataTables.buttons.min.js"></script>
	<script src="/../vendors/datatables/js/buttons.bootstrap4.min.js"></script>
	<script src="/../vendors/datatables/js/buttons.print.min.js"></script>
	<script src="/../vendors/datatables/js/buttons.html5.min.js"></script>
	<script src="/../vendors/datatables/js/buttons.flash.min.js"></script>
	<script src="/../vendors/datatables/js/pdfmake.min.js"></script>
	<script src="/../vendors/datatables/js/vfs_fonts.js"></script>
	<!-- Datatable Setting js -->
	<script src="/../vendors/datatables/scripts/datatable-setting.js"></script>
    
    <script src="{{ asset('lib/bootstrap/js/bootstrap.min.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('lib/bootstrap/js/bootstrap.bundle.js') }}" crossorigin="anonymous"></script>
    <script src="{{ asset('dashboard/js/scripts.js') }}"></script>

    <script src="/../vendors/jquery-asColor/dist/jquery-asColor.js"></script>
	<script src="/../vendors/jquery-asGradient/dist/jquery-asGradient.js"></script>
	<script src="/../vendors/jquery-asColorPicker/jquery-asColorPicker.js"></script>
	<script src="{{ asset('js/colorpicker.js') }}"></script>
    {{-- <script src="{{ asset('/js/custom.js') }}"></script> --}}
</body>

</html>