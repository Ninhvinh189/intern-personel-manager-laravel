<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

    <link href="{{asset('assets/backend/css/styles.css')}}" rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body class="sb-nav-fixed">

{{--<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">--}}
{{--    <!-- Navbar Brand-->--}}
{{--    <a class="navbar-brand ps-3" href="index.html">Start Bootstrap</a>--}}
{{--    <!-- Sidebar Toggle-->--}}
{{--    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>--}}
{{--    <!-- Navbar Search-->--}}
{{--    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">--}}
{{--        <div class="input-group">--}}
{{--            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />--}}
{{--            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>--}}
{{--        </div>--}}
{{--    </form>--}}
{{--    <!-- Navbar-->--}}
{{--    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">--}}
{{--        <li class="nav-item dropdown">--}}
{{--            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>--}}
{{--            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">--}}
{{--                <li><a class="dropdown-item" href="#!">Settings</a></li>--}}
{{--                <li><a class="dropdown-item" href="#!">Activity Log</a></li>--}}
{{--                <li><hr class="dropdown-divider" /></li>--}}
{{--                <li><a class="dropdown-item" href="#!">Logout</a></li>--}}
{{--            </ul>--}}
{{--        </li>--}}
{{--    </ul>--}}
{{--</nav>--}}

{{--header--}}
@include('backend.layout.header')

<div id="layoutSidenav">
    @include('backend.layout.sidebar')

{{--    layout content--}}
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid px-4">
                @yield('content')
            </div>
        </main>

        <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
                <div class="d-flex align-items-center justify-content-between small">
                    <div class="text-muted">Copyright &copy; Your Website 2022</div>
                    <div>
                        <a href="#">Privacy Policy</a>
                        &middot;
                        <a href="#">Terms &amp; Conditions</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
<script src="{{asset('assets/backend/js/scripts.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
</body>

@yield('js')

</html>
