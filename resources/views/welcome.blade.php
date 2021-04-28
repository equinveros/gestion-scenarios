<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@lang('messages.gestionDesScenarios')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}"/>

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Raleway', sans-serif;
            font-weight: 100;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a class="dropdown-item" href="{{ route('board') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('userBoard-form').submit();">
                    {{ Auth::user()->name }}
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                    @lang('messages.logout')
                </a>
                <form id="userBoard-form" action="{{ route('board') }}" method="POST" style="display: none;">
                    <input name="user_id" type="hidden" value="{{ Auth::user()->id }}" class="tg-hidden">
                    {{ csrf_field() }}
                </form>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                </form>

            @else
                <a href="{{ route('login') }}">@lang('messages.login')</a>
                <a href="{{ route('register') }}">@lang('messages.register')</a>
        @endauth
        <!-- @foreach ( config('app.locales') as $local_code => $local_string)
            <a class="flag flag--{{$local_code}}" style='padding:1.5em; margin:5%;' href="{!! url('/') !!}/{{ $local_code }}/"><span></span></a>
            @endforeach-->
        </div>
    @endif

    <div class="content">
        <div class="title m-b-md">
            @lang('messages.gestionDesScenarios')
        </div>
        @auth

            <div class="links">

                @if( Auth::user()->admin  == true);
                <a href="{{ url('/scenarios') }}">
                    <span style="vertical-align: middle">

                    @lang('messages.scenarios')

                    </span>
                    <!-- Icon: arrow right | URL : https://thenounproject.com/term/right/934660/ -->
                    <svg fill="#000000" style="width: 1rem;vertical-align: middle;"
                         xmlns:svg="http://www.w3.org/2000/svg"
                         xmlns="http://www.w3.org/2000/svg" version="1.1" x="0px" y="0px" viewBox="0 0 48 48">
                        <g transform="translate(0,-1004.3622)">
                            <path d="m 44.999995,1028.357 c -0.028,-0.715 -0.3223,-1.5414 -0.8125,-2.0626 l -16,-17.0008 c -1.0842,-0.9743 -3.1632,-1.3765 -4.375,-0.25 -1.1936,1.1095 -1.1581,3.2613 0.031,4.3752 l 11.25,11.9381 -29.0934997,0 c -1.6568,0 -3,1.3432 -3,3.0001 0,1.6569 1.3432,3.0001 3,3.0001 l 29.0934997,0 -11.25,11.9381 c -1.0237,1.0255 -1.2129,3.253 -0.031,4.3752 1.1816,1.1221 3.3353,0.7636 4.375,-0.2501 l 16,-17.0007 c 0.5475,-0.5818 0.8143,-1.2644 0.8125,-2.0626 z"
                                  fill="#000000" fill-opacity="1" fill-rule="nonzero" stroke="none" marker="none"
                                  visibility="visible" display="inline" overflow="visible"></path>
                        </g>
                    </svg>
                </a>
                @endif
            </div>
        @endauth
    </div>
</div>
</body>
</html>
