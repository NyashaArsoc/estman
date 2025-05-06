<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta tags -->
    <meta charset="utf-8">
    <link rel="icon" type="image/svg" href="{{ asset('img/icon.svg') }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Title -->
    <title>ESTMAN | @yield('title')</title>

    <!-- estman CSS -->
    <link rel="stylesheet" href="{{ asset('css/home/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/theme/themify-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/animate.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/jquery.jscrollpane.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/waves.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home/switchery.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/progress/nprogress.css') }}">
    <link rel="stylesheet" href="{{ asset('css/toastr/toastr.min.css') }}">

    <!-- Neptune CSS -->
    <link rel="stylesheet" href="{{ asset('css/home/core.css') }}">
    <link rel="stylesheet" href="{{ asset('css/manage/prev-next/prev-next.css') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('css/manage/search/dataTables.bootstrap4.min.css') }}" /><!--search-->
    <link rel = "stylesheet" type = "text/css" href = "{{ asset('css/popupforms/msg.css') }}" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://rawgit.com/lykmapipo/themify-icons/master/css/themify-icons.css" rel="stylesheet">
    <!--plugin for showing modal details-->
    <script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc="
        crossorigin="anonymous"></script>
    <!--end plugin for showing details-->
    @yield ('additional css')
</head>

<body class="fixed-sidebar fixed-header skin-3 content-appear">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader"></div>
        <!-- Sidebar -->
        <div class="site-overlay"></div>

        <div class="site-sidebar">
            <div class="custom-scroll custom-scroll-dark">
                <ul class="sidebar-menu">
                    <li class="menu-title">Main</li>
                    <li class="with-sub">
                        <a href="{{route('dash.property')}}" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-anchor"></i></span>
                            <span class="s-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-user"></i></span>
                            <span class="s-text">Landlord</span>
                        </a>
                        <ul>
                            <li><a href="{{route('landlord.newlandlord')}}">Add Landlord</a></li>
                            <li><a href="{{route('landlord.addbanking')}}">Add Banking</a></li>
                            <li><a href="{{route('landlord.pending')}}">Approval</a></li>
                            <li><a href="{{route('landlord.rejected')}}">Rejected</a></li>
                            <li><a href="{{route('landlord.list')}}">Manage Landlord</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-user"></i></span>
                            <span class="s-text">Tenants</span>
                        </a>
                        <ul>
                            <li><a href="{{route('tenant.newtenant')}}">Add Tenant</a></li>
                            <li><a href="{{route('tenant.pending')}}">Approval</a></li>
                            <li><a href="{{route('tenant.rejected')}}">Rejected</a></li>
                            <li><a href="{{route('tenant.list')}}">Manage Tenant</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-layout"></i></span>
                            <span class="s-text">Property</span>
                        </a>
                        <ul>
                            <li><a href="{{route('property.newproperty')}}">Add Property</a></li>
                            <li><a href="{{route('property.pending')}}">Approval</a></li>
                            <li><a href="{{route('property.rejected')}}">Rejected</a></li>
                            <li><a href="{{route('property.remit')}}">Remit</a></li>
                            <li><a href="{{route('property.list')}}">Manage Property</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-pencil-alt"></i></span>
                            <span class="s-text">Lease</span>
                        </a>
                        <ul>
                            <li><a href="{{route('lease.addcreate')}}">Add Lease</a></li>
                            <li><a href="{{route('lease.pending')}}">Approval</a></li>
                            <li><a href="{{route('lease.rejected')}}">Rejected</a></li>
                            <li><a href="{{route('lease.list')}}">Manage Lease</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-receipt"></i></span>
                            <span class="s-text">Invoice</span>
                        </a>
                        <ul>
                            <li><a href="{{route('invoice.listpre')}}">Profoma Billed</a></li>
                            <li><a href="{{route('invoice.listeditedprofoma')}}">Profoma Edited</a></li>
                            <li><a href="{{route('invoice.listinv')}}">Generated</a></li>
                            <li><a href="{{route('invoice.listfailed')}}">Failed</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-money"></i></span>
                            <span class="s-text">Transactions </span>
                        </a>
                        <ul>
                            <li><a href="{{route('transact.newbal')}}">Leases Rates</a></li>
                            <li><a href="{{route('transact.payment')}}">Receipt</a></li>
                            <li><a href="{{route('transact.remit')}}">Remittance</a></li>
                            <li><a href="{{route('transact.viewpay')}}">Pay Creditor</a></li>
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-bar-chart"></i></span>
                            <span class="s-text">Reports</span>
                        </a>
                        <ul>
                            <li><a href="{{route('report.viewland')}}">Landlord</a></li>
                            <li><a href="{{route('report.viewprop')}}">Property</a></li>
                            <li><a href="{{route('report.viewtenant')}}">Tenant</a></li>
                            <li><a href="{{route('report.viewlease')}}">Lease</a></li>
                            {{-- <li><a href="{{route('report.viewland')}}">Transaction</a></li> --}}
                        </ul>
                    </li>
                    <li class="with-sub">
                        <a href="#" class="waves-effect  waves-light">
                            <span class="s-caret"><i class="fa fa-angle-down"></i></span>
                            <span class="s-icon"><i class="ti-settings"></i></span>
                            <span class="s-text">Setting</span>
                        </a>
                        <ul>
                            <li><a href="{{route('login.profile')}}">Profile</a></li>
                            <li> <a href="{{route('login.signout')}}">Sign Out</a></li>
                        </ul>
                    </li>                  
                </ul>
            </div>
        </div> <!-- Sidebar second -->
        <!-- Header -->
        <div class="site-header">
            <nav class="navbar navbar-light">
                <div class="navbar-left">
                    <a class="navbar-brand" href="{{route('dash.main')}}">
                        <img src="{{ asset('img/ESTMANLOGO.png') }}" class="logo">
                    </a>
                    <div class="toggle-button light sidebar-toggle-first float-xs-left hidden-md-up">
                        <span class="hamburger"></span>
                    </div>
                    <div class="toggle-button-second light float-xs-right hidden-md-up">
                        <i class="ti-arrow-left"></i>
                    </div>
                    <div class="toggle-button light float-xs-right hidden-md-up" data-toggle="collapse"
                        data-target="#collapse-1">
                        <span class="more"></span>
                    </div>
                </div>
                <div class="navbar-right navbar-toggleable-sm collapse" id="collapse-1">
                    <div class="toggle-button sidebar-toggle-second float-xs-left hidden-sm-down light">
                        <span class="hamburger"></span>
                    </div>
                    <ul class="nav navbar-nav float-md-right">

                        <li class="nav-item dropdown hidden-sm-down">
                            <a href="#" data-toggle="dropdown" aria-expanded="false">
                                <span class="avatar box-32">
                                    <img src="{{ asset('img/profile.jpg') }}" alt="">
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right animated fadeInUp">
                                <a class="dropdown-item" href="{{route('login.profile')}}">
                                    <i class="ti-user mr-0-5"></i> Profile </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{route('login.signout')}}"><i class="ti-power-off mr-0-5"></i> Sign
                                    Out</a>
                            </div>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav">
                        <li class="nav-item hidden-sm-down light">
                            <a class="nav-link toggle-fullscreen" href="#">
                                <i class="ti-fullscreen"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>
        <div class="site-content">
            <!-- Content -->
            <div class="content-area py-1">
                <div class="container-fluid">
              <!--content start-->
                    @yield ('content')
                <!--content ends-->
                </div>
            </div>
            <!-- Footer -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row text-xs-center">
                        <div class="col-sm-5 text-sm-left mb-0-5 mb-sm-0">
                            © <a class="nav-link text-black" target="new"
                                href="https://www.arsoc.co.zw"> arsoc</a> - All rights reserved
                        </div>
                        <div class="col-sm-7 text-sm-right">

                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <!-- Scripts -->
    <script type="text/javascript" src="{{ asset('js/home/jquery-1.12.3.min.js') }}"></script>
    <script src="{{ asset('js/home/jquery-ui.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/tether.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/manage/search/jquery.min.js') }}"></script><!-- Search -->
    <script src="{{ asset('js/manage/search/jquery.dataTables.min.js') }}"></script><!-- Search -->
    <script src="{{ asset('js/manage/search/dataTables.bootstrap4.min.js') }}"></script><!-- Search -->
    <script type="text/javascript" src="{{ asset('js/home/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/detectmobilebrowser.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/jquery.mousewheel.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/mwheelIntent.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/jquery.jscrollpane.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/jquery.fullscreen-min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/waves.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/switchery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/raphael.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/morris.min.js') }}"></script>


    <script type="text/javascript" src="{{ asset('js/home/demo.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/home/app.js') }}"></script>

    <script src="{{ asset('js/manage/search/responsive-search.js') }}"></script><!-- Search -->
    <script type="text/javascript" src="{{ asset('js/popupforms/manage-buttons.js') }}"></script>
    @yield ('additional js')

</body>

</html>
