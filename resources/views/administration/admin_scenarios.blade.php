@extends('layouts.app')

@section('page')
    <li><strong><span class="nav-link">@lang('messages.gestionDesScenarios')</span></strong></li>
@endsection
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{--<div class="card">--}}
                {{--<div class="card-header">{{ __('Administration') }}</div>--}}
                <h1>@lang('messages.gestionDesScenarios')</h1>
                <div class="text-right m-2">
                    <a href="{{ route('new') }}" class="btn btn-primary">@lang('messages.new')</a>
                </div>

                <table class="table-responsive box">
                    <thead>

                    <tr>
                        <th>@lang('messages.name')</th>
                        <th>@lang('messages.site')</th>
                        <th>@lang('messages.description')</th>
                        <th>@lang('messages.context')</th>
                        <th>@lang('messages.state')</th>
                        <th>@lang('messages.priority')</th>
                        <th>@lang('messages.action')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse ($scenarios as $scenario)
                        <tr>
                            <td>{{ $scenario->name }}</td>
                            <td>{{ $scenario->siteTitle }}</td>
                            <td>{{ $scenario->description }}</td>
                            <td>{{ $scenario->context }}</td>
                            <td nowrap="nowrap"><span class="state-label state-label--{{ $scenario->state }}">@lang("states.".$scenario->state)</span></td>
                            <td nowrap="nowrap">@lang("priorities.".$scenario->priority)</td>
                            <td>
                                <a class="p-2 link"  id="{{$scenario->id}}_view"
                                       href="{{ URL::action('ScenarioController@view', [$scenario->id, 1, 'fr']) }}">
                                    <span>Voir</span>
                                </a>
                                <a class="p-2 link" id="{{$scenario->id}}_edit"
                                   href="{{ route('edit',$scenario->id) }}">
                                    <span>Éditer</span>
                                </a>
                                <a class="p-2 link"  id="{{$scenario->id}}_showAllByScenario"
                                   href="{{ URL::action('StepController@showAllByScenario', $scenario->id) }}">
                                    <span>Étapes</span>
                                </a>
                                @if( Auth::user()->admin  == true || Auth::user()->profil_id == 1)
                                <a class="p-2 link"  id="{{$scenario->id}}_close"
                                   href="{{ route('close',$scenario->id) }}">
                                <span>Clôturer</span>
                                </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <p>@lang('messages.scenariosNull')</p>
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
