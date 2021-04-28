@extends('layouts.app')

@section('page')
<li><a class="nav-link" href="{{ url('/scenarios') }}">@lang('messages.gestionDesScenarios')</a></li>
@if ($newScenario)
<li><strong><span class="nav-link">@lang('messages.newScenario')</span></strong></li>
@else
<li><strong><span class="nav-link">@lang('messages.editScenario')</span></strong></li>
@endif
@endsection
@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card">

        @if ($newScenario)
        <div class="card-header">@lang('messages.newScenario')</div>.
          @php
            $route = route('scenario_register');
          @endphp
        @else
        <div class="card-header">{{$scenario->name}}</div>
          @php
            $route = url('/scenario/update/' . $scenario->id);
          @endphp
        @endif

        <div class="card-body">
          <form method="POST" action="{{$route}}">
            {{ csrf_field() }}
            @if (!$newScenario)
            <input id="scenario_id" type="hidden" value="{{$scenario->id}}" class="tg-hidden">
            @endif
            {{--@if (Auth::user())--}}
            <input id="user_id" name="user_id" type="hidden" value="{{Auth::user()->id}}" class="tg-hidden">
            {{--@endif--}}
            <div class="form-group row">
              <label for="name" class="col-md-4 col-form-label text-md-right">@lang('messages.name')</label>

              <div class="col-md-6">
                <input id="name" type="text"
                class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}"
                name="name" value="@if($scenario){{ $scenario->name }}@endif" required
                autofocus>

                @if ($errors->has('name'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
              </div>
            </div>

            <div class="form-group row">
              <label for="model"
              class="col-md-4 col-form-label text-md-right">@lang('messages.model')</label>

              <div class="col-md-6">
                <select class="form-control @if($scenario) tg-disabled @endif" id="model" name="model" >
                  @forelse ($sites as $site)
                  <option value="{{$site->id}}"
                    @if($scenario && $site->id == $scenario->site_id )  selected @endif
                    >{{$site->title}}</option>
                    @empty

                    @endforelse
                  </select>
                  @if ($errors->has('model'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('model') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="description"
                class="col-md-4 col-form-label text-md-right">@lang('messages.description')</label>

                <div class="col-md-6">
                  <textarea id="description" rows="5"
                  class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}"
                  name="description"
                  required>@if($scenario){{ $scenario->description }}@endif</textarea>
                  @if ($errors->has('description'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('description') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="context"
                class="col-md-4 col-form-label text-md-right">@lang('messages.context')</label>
                <div class="col-md-6">
                  <textarea id="context" row="2"
                  class="form-control{{ $errors->has('context') ? ' is-invalid' : '' }}"
                  name="context"
                  required>@if($scenario){{ $scenario->context }}@endif</textarea>
                  @if ($errors->has('context'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('context') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="priority"
                class="col-md-4 col-form-label text-md-right">@lang('messages.priority')</label>

                <div class="col-md-6">
                  <select class="form-control" id="priority" name="priority">
                    @forelse ($priorities as $key => $priority)
                    <option value="{{$key}}"
                    @if($scenario && $key == $scenario->priority ) selected @endif
                    >@lang("priorities.".$key)</option>
                    @empty

                    @endforelse
                  </select>
                  @if ($errors->has('priority'))
                  <span class="invalid-feedback">
                    <strong>{{ $errors->first('priority') }}</strong>
                  </span>
                  @endif
                </div>
              </div>

              @if (!$newScenario)
              <div class="form-group row">
                <label for="state"
                class="col-md-4 col-form-label text-md-right">@lang('messages.state')</label>

                <div class="col-md-6">
                  <select class="form-control" id="state"
                  name="state">
                  @forelse ($states as $key => $state)
                  <option value="{{$key}}"
                  @if($scenario && $key == $scenario->state ) selected @endif
                  >@lang("states.".$key)</option>
                  @empty
                  @endforelse
                </select>
                @if ($errors->has('state'))
                <span class="invalid-feedback">
                  <strong>{{ $errors->first('state') }}</strong>
                </span>
                @endif
              </div>
            </div>
            @endif
            <div class="form-group row mb-0">
              <div class="col-md-6 offset-md-4 text-right">
                <button type="submit" class="btn btn-primary">
                  @lang('messages.save')
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
