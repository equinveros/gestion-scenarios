<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Gestion de scenarios') }}</title>

{{--<script type="text/javascript"--}}
{{--src="https://cdnjs.cloudflare.com/ajax/libs/iframe-resizer/3.6.1/iframeResizer.min.js"></script>--}}


<!-- Scripts -->
    <script src="{{ URL::asset('js/app.js') }}" defer></script>
    <script type="text/javascript" src="{{ URL::asset('js/kinetic.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/jquery.js') }}"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css"
          integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ URL::asset('css/elements2.css')}}"/>
    <link rel="stylesheet" href="{{ URL::asset('css/classes2.css')}}"/>
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}"/>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.4.0/min/dropzone.min.css">


</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{--                {{ config('app.name', 'Gestion de scenarios') }}--}}
                @lang('messages.home')
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                    @guest
                    @else
                        @if( Auth::user()->admin  == true)

                            @yield('page')
                        @endif
                    @endguest
                </ul>
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li><a class="nav-link" href="{{ route('login') }}">@lang('messages.login')</a></li>
                        <li><a class="nav-link" href="{{ route('register') }}">@lang('messages.register')</a></li>
                    @else
                        <li class="nav-link">
                            <a href="{{ route('board') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('userBoard-form').submit();">
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                        <li class="nav-link">
                            <a href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                @lang('messages.logout')
                            </a>
                        </li>
                        <form id="userBoard-form" action="{{ route('board') }}" method="POST" style="display: none;">
                            <input name="user_id" type="hidden" value="{{ Auth::user()->id }}" class="tg-hidden">

                            {{ csrf_field() }}
                        </form>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    <!-- @foreach ( config('app.locales') as $local_code => $local_string)
                            @if($local_string !== config('app.lang_name'))
                                <?php
                                $style = 'padding:0';
                                if ($local_code == session('applocale')) {
                                    $style = 'padding:0;border-bottom:2px solid red;';
                                }
                                ?>
                                    <a class="p-3 m-2 flag flag--{{$local_code}}" style='<?php echo $style;?>' href="{!! url('/') !!}/{{ $local_code }}/"><span></span></a>
                            @endif
                                @endforeach-->
                            @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        <div id="myModal" class="modal tg-hidden">
            <div style="margin: 15% ">
                <div class="modal-content">

                    <div id="modal-header" class="modal-header">
                        <span class="close">&times;</span>
                    </div>
                    <div id="modal-body" class="modal-body">
                        ...
                    </div>

                    <div id="modal-footer" class="modal-footer">

                        <button id="modalCancel" type="button" class="btn  btn-ok">@lang('messages.cancel')</button>
                        <button id="modalNoSave" type="button"
                                class="btn btn-ok tg-hidden">@lang('messages.noSave')</button>
                        <button id="modalSave" type="button" class="btn btn-primary"
                                data-dismiss="modal">@lang('messages.save')
                        </button>
                    </div>
                </div>
            </div>

        </div>
        @yield('content')
    </main>
</div>
</body>
</html>
