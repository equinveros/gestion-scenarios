@extends('layouts.app')

@section('page')
@endsection

@section('content')
    <div class="container">
        <h1>@lang('messages.admin')</h1>
        <div class="tg-cols tg-cont-2">
            {{--@if ($homeAdmin)--}}
            <div class="tg-grid-6 text-center h2 box border">
                <a class="nav-link" href="{{ url('/scenarios') }}">@lang('messages.scenarios')</a>
            </div>
            <div class="tg-grid-6 tg-grid-end text-center h2 box border">
                <a class="nav-link" href="{{ url('/steps') }}">@lang('messages.step')</a>
            </div>
            {{--@endif--}}
        </div>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
@endsection
