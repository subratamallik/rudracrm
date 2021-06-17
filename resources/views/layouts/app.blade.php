<html>

<head>
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/bootstrap-4.3.1-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/fontawesome-free-5.15.3-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css?v=1.2') }}">
</head>

<body>
    @include('layouts/flash-message')
    <header>
        <div class="header">
            <div class="row">
                <div class="col-md-6 leftpart">
                    <a href="{{url('/')}}">Call Center</a>
                </div>
                <div class="col-md-6 text-right rightpart">
                    Welcome, {{Session::get('logged_user')['name']}} ({{Session::get('logged_user')['roleName']}})
                    <a href="{{url('logout')}}" class="btn btn-danger btn-sm ml-2">Logout</a>
                </div>
            </div>
        </div>
    </header>
    <div class="sidebar">
        <div class="logo mb-2">
            <a href="{{url('/')}}"><img src="{{ asset('assets/images/logo-1.jpg') }}" class="w100pc" alt=""></a>
        </div>
        <!-- <span class="text-white">{{lastRoute(0)}}</span> -->
        <p class="mb-1 dashbrd  @if (lastRoute()=='') active @endif"><a href="{{url('/')}}">Dashboard</a></p>
        <!-- Menu -->
        @if (count(Session::get('user_menus'))>0)
        @foreach (Session::get('user_menus') as $items)
        @if (count($items->sub_menu)>0)
        <p>{{$items->title}}</p>
        <div class="submenu">
            @foreach ($items->sub_menu as $itemSub)
            <a href="{{url($itemSub->route)}}" @if ($itemSub->route==Request::path()) class="active"
                @endif>{{$itemSub->title}}</a>
            @endforeach
        </div>
        @endif
        @endforeach
        @endif
    </div>
    <div class="wrapper_container">
        @yield('content')
    </div>
    <div class="pageLoader">
        <div class="pageLoaderInner">
            Loading...
        </div>
    </div>
    <?php /* ?>
    <div class="techSupoort">
        <p>For Technical Support</p>
        <a class="btn btn-warning btn-sm" href="https://chat.whatsapp.com/LGkKMk2TFMICQZ45LjrEcF" target="_blank"><i class="fab fa-whatsapp"></i> Chat Now</a>
    </div>
    <?php */ ?>
</body>
<script src="{{ asset('assets/js/jquery-3.5.1.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap-4.3.1-dist/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/bootstrap-4.3.1-dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/js/custom.js?v=1.0') }}"></script>
@yield('script')

</html>