@extends('layouts.app')

@section('page')
    <li><a class="nav-link" href="{{ url('/scenarios') }}">@lang('messages.gestionDesScenarios')</a></li>
    <li><strong><span class="nav-link">@lang('messages.steps')</span></strong></li>
@endsection
@section('content')
    <div class="container">
        {{--<div class="card">--}}
        {{--<div class="card-header">{{ __('Administration') }}</div>--}}
        @if ($showByScenario)
            <div class="tg-pos-right">
                <a href="{{ URL::action('ScenarioController@showAll') }}">@lang('messages.backToList')</a>
            </div>
        @endif
        <h1>@lang('messages.steps')</h1>

        <table class="box">
            <thead>

            <tr>
                <th>@lang('messages.name')</th>
                @if (!$showByScenario)
                    <th>@lang('messages.scenario')</th>
                @endif
                <th>@lang('messages.description')</th>
                <th>@lang('messages.priority')</th>
                <th>@lang('messages.state')</th>
                <th>@lang('messages.page')</th>
                <th>@lang('messages.lang')</th>
                <th>@lang('messages.action')</th>
            </tr>
            </thead>
            <tbody>

            @forelse ($steps as $step)
                <tr>
                    <td>{{ $step->name }}</td>
                    @if (!$showByScenario)
                        <td>{{ $step->scenario->name }}</td>
                    @endif
                    <td>{{ $step->description }}</td>
                    <td>@lang("priorities.".$step->priority)</td>
                    <td ><span class="state-label state-label--{{ $step->state }}">@lang("states.".$step->state)</span></td>

                    <td>{{ $step->page->url }}</td>
                    <td>
                        {{$langs[$step->lang]['libelle']}}
                    </td>
                    <td>
                        <a id="{{$step->scenario_id}}_{{$step->step_number}}view"
                           href="{{ URL::action('ScenarioController@view', [$step->scenario_id, $step->step_number, 'fr']) }}">
                            <span>Éditer</span>
                        </a>
                    </td>

                </tr>
            @empty
                <p>@lang('messages.nosteps')</p>
            @endforelse
            </tbody>
        </table>
        {{--</div>--}}
        {{--</div>--}}
    </div>
@endsection
