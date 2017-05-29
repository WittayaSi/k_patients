<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="token" id="token" value="{{ csrf_token() }}">

    <title>{{ config('app.name','') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app-style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sweetalert.css') }}">
    <link rel="stylesheet" href="{{ asset('fullcalendar/fullcalendar.css') }}">

    <!-- Scripts -->
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" charset="utf-8"></script>
    <script src="{{ asset('js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('fullcalendar/moment.min.js') }}"></script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top alert-success">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name','') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li class="{{ Request::is('home') ? 'active' : '' }}"><a href="{{ url('/home') }}"><i class="fa fa-home fa-lg"></i></a></li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="{{ Request::is('patient') ? 'active' : '' }}"><a href="{{ url('/patient') }}"><i class="fa fa-address-book fa-lg"></i> ข้อมูลผู้ป่วย</a></li>
                        <li class="{{ Request::is('appointment') ? 'active' : '' }}"><a href="{{ url('/appointment') }}"><i class="fa fa-newspaper-o fa-lg"></i> รายงานการนัด</a></li>
                        @if(Auth::check() && Auth::user()->is_admin === 'Y')
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle {{ Request::is('setting/*') ? 'active' : '' }}" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <i class="fa fa-cogs fa-lg"></i> จัดการระบบ <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/setting/discode') }}">
                                            <i class="fa fa-book"></i> จัดการรหัสโรค
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/hoscode') }}">
                                            <i class="fa fa-plus-square"></i> จัดการรหัสสถานบริการ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/hosrefcode') }}">
                                            <i class="fa fa-h-square"></i> จัดการรหัสโรงพยาบาลส่งต่อ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/pnamecode') }}">
                                            <i class="fa fa-address-book-o"></i> จัดการรหัสคำนำหน้าชื่อ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/mstatuscode') }}">
                                            <i class="fa fa-mars-double"></i> จัดการรหัสสถานภาพสมรส
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/educationcode') }}">
                                            <i class="fa fa-list-alt"></i> จัดการรหัสการศึกษา
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/occupationcode') }}">
                                            <i class="fa fa-briefcase"></i> จัดการรหัสอาชีพ
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/religioncode') }}">
                                            <i class="fa fa-snowflake-o"></i> จัดการรหัสศาสนา
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/tamboncode') }}">
                                            <i class="fa fa-thumb-tack"></i> จัดการรหัสตำบล
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ url('/setting/nationcode') }}">
                                            <i class="fa fa-flag"></i> จัดการรหัสสัญชาติ
                                        </a>
                                    </li>
                                    <hr>
                                    <li>
                                        <a href="{{ url('/setting/user') }}">
                                            <i class="fa fa-users"></i> จัดการระบบผู้ใช้งาน
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endif
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                <i class="fa fa-user-circle fa-lg"></i> ยินดีต้อนรับ :: {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ url('/logout') }}"
                                        onclick="event.preventDefault();
                                                    document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> ออกจากระบบ
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <p class="label label-warning">{{ date('l F d , Y') }}</p>
        </div>
        
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/js/vue.min.js')}}"></script>
    <script src="{{ asset('/js/vue-resource.min.js')}}"></script>
    <script src="{{ asset('/js/axios.min.js')}}"></script>
    <script src="{{ asset('/fullcalendar/fullcalendar.js') }}"></script>
    <script src="{{ asset('/fullcalendar/locale/th.js') }}"></script>
    @stack('scripts')
    
</body>
</html>
