@extends('layouts.app')

@section('page')
@endsection

@section('content')
    <div class="container">
        <h1 class=" box p-2">@lang('messages.board')</h1>

        <section class="row">
            <div class="col-lg-7">
                <div class="box p-4">
                    <h2 class="bg-primary text-white box p-2">@lang('messages.infos')</h2>
                    <form method="POST" action="{{ route('register') }}">
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="name"
                                   class="col-md-4 col-form-label text-md-right"> @lang('messages.name')</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                       class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name"
                                       value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email"
                                   class="col-md-4 col-form-label text-md-right">@lang('messages.email')</label>

                            <div class="col-md-6">
                                <input id="email" type="email"
                                       class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email"
                                       value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="company"
                                   class="col-md-4 col-form-label text-md-right">@lang('messages.company')</label>

                            <div class="col-md-6">
                                <input id="company" type="text" class="form-control tg-disabled" name="company"
                                       value="{{ $user->company }}" required>

                                @if ($errors->has('company'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('company') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password"
                                   class="col-md-4 col-form-label text-md-right"> @lang('messages.password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password"
                                       class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}"
                                       name="password" required>

                                @if ($errors->has('password'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm"
                                   class="col-md-4 col-form-label text-md-right"> @lang('messages.confirmPassword')</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control"
                                       name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="text-right col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    @lang('messages.validate')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="box p-4 mb-2">
                    <h2 class="bg-primary text-white box p-2">@lang('messages.profil')</h2>

                    <form>
                        <div class="form-group row">

                            <label class="col-md-3 col-form-label text-md-right" for="userList">@lang('messages.userList')</label>
                            <select class="col-md-7 form-control" id="userList" name="userList">
                                @forelse ($users as $u)
                                    <option value="{{$u['id']}}">{{$u['company']}} : {{$u['name']}} </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group row">

                            <label class="col-md-3 col-form-label text-md-right" for="profilList">@lang('messages.profilList')</label>
                            <select class="col-md-7 form-control" id="profilList" name="profilList">
                                @forelse ($profils as $p)
                                    <option value="{{$p['id']}}">{{$p['name']}} </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                        <div class="form-group row ">
                            <div class="text-right col-md-5 ">
                                <a href="{{ route('userList')}}">@lang('messages.linkUserList')</a>
                            </div>
                            <div class="text-right col-md-7 ">
                                <button type="submit" class="btn btn-primary">
                                    @lang('messages.validate')
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="box p-4">
                    <h2 class="bg-primary text-white box p-2">@lang('messages.access')</h2>

                </div>

            </div>
        </section>
        <main class="py-4">
            @yield('content')
        </main>

    </div>
@endsection
        <script type="text/javascript" src="{{ URL::asset('js/script_User.js') }}"></script>
