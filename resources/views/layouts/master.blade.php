<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hello Vans</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <!-- <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro&display=swap" rel="stylesheet"> -->

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <div class="wrapper">
            <!-- Navbar -->
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="/admin" class="nav-link">Home</a>
                    </li>
                    <li class="nav-item d-none d-sm-inline-block">
                        <a href="#" class="nav-link">Contact</a>
                    </li>
                </ul>

                <!-- SEARCH FORM -->
                <form class="form-inline ml-3">
                    <div class="input-group input-group-sm">
                        <input class="form-control form-control-navbar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-navbar" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Messages Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-comments"></i>
                            <span class="badge badge-danger navbar-badge">3</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/img/profile.png" alt="User Avatar" class="img-size-50 mr-3 img-circle">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Brad Diesel
                                            <span class="float-right text-sm text-danger"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">Call me whenever you can...</p>
                                        <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/img/profile/1537591603.png" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            John Pierce
                                            <span class="float-right text-sm text-muted"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">I got your message bro</p>
                                        <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <!-- Message Start -->
                                <div class="media">
                                    <img src="/img/profile/1537591603.png" alt="User Avatar"
                                        class="img-size-50 img-circle mr-3">
                                    <div class="media-body">
                                        <h3 class="dropdown-item-title">
                                            Nora Silvester
                                            <span class="float-right text-sm text-warning"><i
                                                    class="fas fa-star"></i></span>
                                        </h3>
                                        <p class="text-sm">The subject goes here</p>
                                        <p class="text-sm text-muted"><i class="fas fa-clock mr-1"></i> 4 Hours Ago</p>
                                    </div>
                                </div>
                                <!-- Message End -->
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
                        </div>
                    </li>
                    <!-- Notifications Dropdown Menu -->
                    <li class="nav-item dropdown">
                        <a class="nav-link" data-toggle="dropdown" href="#">
                            <i class="fas fa-bell"></i>
                            <span class="badge badge-warning navbar-badge">15</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                            <span class="dropdown-header">15 Notifications</span>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 4 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-users mr-2"></i> 8 friend requests
                                <span class="float-right text-muted text-sm">12 hours</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-file mr-2"></i> 3 new reports
                                <span class="float-right text-muted text-sm">2 days</span>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                        </div>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-power-off"></i>
                            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
                                class="fas fa-th-large"></i></a>
                    </li>
                </ul>
            </nav>
            <!-- /.navbar -->


            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="/admin" class="brand-link">
                    <img src="/img/logo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                    <span class="brand-text font-weight-light">Hello Vans</span>
                </a>

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->
                    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            <img src="/img/profile.png" class="img-circle elevation-2" alt="User Image">
                        </div>
                        <div class="info">
                            <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                        </div>
                    </div>

                    <!-- Sidebar Menu -->
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-item">
                                <router-link :to="{ name: 'dashboard' }" class="nav-link">
                                    <i class="nav-icon fas fa-tachometer-alt"></i>
                                    <p>Dashboard</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'global-settings' }" class="nav-link">
                                    <i class="nav-icon fas fa-cogs"></i>
                                    <p>Global settings</p>
                                </router-link>
                            </li>
                            
                            <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                            <li class="nav-item">
                                <router-link :to="{ name: 'statistics-charts' }" class="nav-link">
                                    <i class="nav-icon fas fa-chart-line"></i>
                                    <p>Statistics & charts</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'jobs' }" class="nav-link">
                                    <i class="nav-icon fas fa-truck-loading"></i>
                                    <p>Jobs</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'quotes' }" class="nav-link">
                                    <i class="nav-icon fas fa-search-location"></i>
                                    <p>Quotes</p>
                                </router-link>
                            </li>
                            
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-globe-europe"></i>
                                    <p>
                                        Maps
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'drivers-places' }" class="nav-link">
                                            <i class="fas fa-map-marked-alt nav-icon"></i>
                                            <p>Drivers places</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'areas-we-cover' }" class="nav-link">
                                            <i class="fas fa-drafting-compass nav-icon"></i>
                                            <p>Areas we cover</p>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <!-- <li class="nav-item">
                                <router-link :to="{ name: 'calendar' }" class="nav-link">
                                    <i class="nav-icon fas fa-calendar-alt"></i>
                                    <p>
                                        Calendar
                                    </p>
                                </router-link>
                            </li> -->
                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>
                                        Users
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'customers' }" class="nav-link">
                                            <i class="fas fa-user-tag nav-icon"></i>
                                            <p>Customers</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'drivers' }" class="nav-link">
                                            <i class="fas fa-people-carry nav-icon"></i>
                                            <p>Drivers</p>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'admins' }" class="nav-link">
                                    <i class="nav-icon fas fa-user-shield"></i>
                                    <p>
                                        Admins
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="{ name: 'dynamic-page' }" class="nav-link">
                                    <i class="fas fa-file nav-icon"></i>
                                    <p>Dynamic Pages</p>
                                </router-link>
                            </li>

                            

                            <li class="nav-item has-treeview">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-copy"></i>
                                    <p>
                                        Pages
                                        <i class="right fas fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'home-page' }" class="nav-link">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>Home</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'faq-page' }" class="nav-link">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>FAQ</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'privacy-page' }" class="nav-link">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>Privacy Policy</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'terms-page' }" class="nav-link">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>Terms And Conditions</p>
                                        </router-link>
                                    </li>
                                    <li class="nav-item">
                                        <router-link :to="{ name: 'drivers-terms-page' }" class="nav-link">
                                            <i class="fas fa-file nav-icon"></i>
                                            <p>Drivers Terms And Conditions</p>
                                        </router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'my-profile' }" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        My profile
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'metas' }" class="nav-link">
                                    <i class="nav-icon fas fa-terminal"></i>
                                    <p>
                                        Metas
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'tests' }" class="nav-link">
                                    <i class="nav-icon fas fa-vials"></i>
                                    <p>Test</p>
                                </router-link>
                            </li>    

                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
            <!-- / Main Sidebar Container -->

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                

                <!-- Main content -->
                <div class="content">
                    <router-view></router-view>
                </div>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
                <div class="p-3">
                    <h5>Title</h5>
                    <p>Sidebar content</p>
                </div>
            </aside>
            <!-- /.control-sidebar -->

            <!-- Main Footer -->
            <footer class="main-footer">
                <!-- To the right -->
                <div class="float-right d-none d-sm-inline">
                    Anything you want
                </div>
                <!-- Default to the left -->
                <strong>Copyright &copy; 2014-2019 <a href="/">Admin</a>.</strong> All rights
                reserved.
            </footer>

        </div>
        <!-- ./wrapper -->
    </div>
    <script>
    window.Laravel = {!! json_encode([
        'csrfToken' => csrf_token(),
        'apiToken' => $currentUser->api_token ?? null,
    ]) !!};
    </script>
</body>
