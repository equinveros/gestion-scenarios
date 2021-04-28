@extends('layouts.app')

@section('page')
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Administration') }}</div>--}}
                <h1>@lang('messages.linkUserList')</h1>
                <div class="text-right m-2">
                    <a href="{{ route('new') }}" class="btn btn-primary">@lang('messages.new')</a>
                </div>

                <table class="box">
                    <thead>

                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.email')</th>
                        <th>@lang('messages.company')</th>
                        <th>@lang('messages.profilList')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->company }}</td>
                            <td>{{ $user->profil }}</td>
                            <td>
                                <a class="p-2 link"  id="{{$user->id}}_view"
                                   href="{{ route('editUser',$user->id) }}">
                                <span>@lang("messages.edit")</span>
                                </a>
                                <a class="p-2 link" id="{{$user->id}}_edit"
                                   href="{{ route('deleteUser',$user->id) }}">
                                    <span>@lang("messages.delete")</span>
                                </a>
                                {{--<a class="p-2 link"  id="{{$user->id}}_showAllByScenario"--}}
{{--                                   href="{{ route('UserScenariosList',$user->id) }}">--}}
                                {{--<span>@lang("messages.scenarios")</span>--}}
                                {{--</a>--}}
                            </td>
                        </tr>
                    @empty
                        <p>@lang('messages.usersNull')</p>
                    @endforelse
                    </tbody>
                </table>
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection
{{--<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>--}}
