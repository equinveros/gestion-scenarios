@extends('layouts.app')
@section('page')
    <li><a class="nav-link" href="{{ url('/scenarios') }}">@lang('messages.gestionDesScenarios')</a></li>
    <li><strong><span class="nav-link">@lang('messages.viewScenario')</span></strong></li>
@endsection
@section('content')
    <div class="tg-cols tg-cont-2">

        <div class="tg-grid-6">
            <div class="box p-4">

                <div class="h2">
                    {{ $scenario->name }}
                </div>
                <p>
                    {{ $scenario->description }}
                </p>
                <p>
                    <strong>@lang('messages.context'): </strong>{{ $scenario->context }}
                </p>
            </div>
        </div>
        <div class="tg-grid-6 tg-grid-last">
            <div class="box p-4">

                <div class="h2">
                    {{ $step->name }}
                </div>
                <p>
                    {{ $step->description }}
                </p>
                <p>
                    <strong>@lang('messages.context'): </strong>{{ $scenario->context }}
                </p>
            </div>
        </div>
    </div>
    <form action="">
        <input id="scenario_id" type="text" class="tg-hidden" value="{{$scenario->id}}">
        @if(isset($step))
            <input id="step_number" type="text" class="tg-hidden" value="{{$step->step_number}}">
        @endif
        @if(isset($lang))
            <input id="current_lang" type="text" class="tg-hidden" value="{{$lang}}">
        @endif
    </form>

    <br/>
    <section class="row">
        <div class="col-lg-7 ">
            <div class="container ">
                <iframe sandbox="allow-scripts" id="iframe" name="iframe" class="frame box p-4 " hspace="0"
                        scrolling="no"
                        src=""
                        frameborder="0">
                </iframe>

                <div class="overlay kineticjs-content" id="overlay">
                </div>
            </div>
        </div>
        <div class="col-lg-5 md-order-first">
            <div class="box p-4">
                <div class="d-flex justify-content-between align-items-start">
                    <ul class="changelang pl-0 pr-4 no-flex-shrink">
                        @forelse ($langs as $key => $lang)
                            <li>
                                <button class="btn btn-default change_lang" id="change_lang_{{$key}}">
                                    <span class="flag flag--{{$key}}"></span>
                                </button>
                            </li>
                        @empty

                        @endforelse
                    </ul>

                    <form>
                        <select class="form-control" id="page" name="page">
                            @forelse ($pages as $key => $page)
                                <option value="{{$key}}">{{$page->url}}</option>
                            @empty

                            @endforelse
                        </select>
                    </form>
                </div>
                <br/>

                <div class="edit-form-controls d-flex justify-content-between align-items-start">
                    <div class="edit-form-navigation no-flex-shrink">
                        <button class="btn btn-default" id="previous">
                        <!--<img class="tg-icon" alt="<" src="{{ asset('img/gauche.png') }}">-->
                            <!-- Icon: back | URL : https://thenounproject.com/term/back/865871/ -->
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" x="0px"
                                 y="0px">
                                <path d="M50,91A41,41,0,1,1,91,50,41,41,0,0,1,50,91Zm0-76A35,35,0,1,0,85,50,35,35,0,0,0,50,15Z"></path>
                                <path d="M57.75,72.16a3,3,0,0,1-1.92-.7l-23.5-19.6a3,3,0,0,1,0-4.62L55,28.53a3,3,0,1,1,3.83,4.62L38.94,49.57,59.67,66.86a3,3,0,0,1-1.92,5.3Z"></path>
                            </svg>
                            <span class="tg-visually-hidden"><</span>
                        </button>
                        <button class="btn btn-default" id="next">
                        <!--<img class="tg-icon" alt=">" src="{{ asset('img/droite.png') }}">-->
                            <!-- Icon: next | URL : https://thenounproject.com/term/next/865868/ -->
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" x="0px"
                                 y="0px">
                                <path d="M48,91A41,41,0,1,1,89,50,41,41,0,0,1,48,91Zm0-76A35,35,0,1,0,83,50,35,35,0,0,0,48,15Z"></path>
                                <path d="M41.12,72.16a3,3,0,0,1-1.92-5.31L59.06,50.43,38.33,33.14a3,3,0,0,1,3.84-4.61l23.5,19.6a3,3,0,0,1,0,4.61L43,71.48A3,3,0,0,1,41.12,72.16Z"></path>
                            </svg>
                            <span class="tg-visually-hidden">></span>
                        </button>
                        <div class="text-center">
                            <span id="nowPage"></span> - <span id="allPages"></span>
                        </div>
                    </div>
                    <div class="edit-form-tools">
                        <button class="btn btn-default mode" id="normal">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 24 24" style="enable-background:new 0 0 24 24;" xml:space="preserve">
                                <path d="M15,24c-2.068,0-4.013-0.805-5.474-2.267L3.06,15.267c-0.361-0.361-0.56-0.84-0.56-1.351C2.5,12.857,3.356,12,4.41,12    c0.463,0,0.927,0.109,1.341,0.316L8.5,13.691V2c0-1.103,0.897-2,2-2s2,0.897,2,2v3.269C12.794,5.098,13.136,5,13.5,5    c0.871,0,1.614,0.56,1.888,1.338C15.706,6.125,16.089,6,16.5,6c0.871,0,1.614,0.56,1.888,1.338C18.706,7.125,19.089,7,19.5,7    c1.103,0,2,0.897,2,2v8.5C21.5,21.084,18.584,24,15,24z M4.41,13c-0.502,0-0.91,0.408-0.91,0.91c0,0.249,0.095,0.478,0.267,0.649    l6.467,6.466C11.506,22.299,13.198,23,14.999,23c3.033,0,5.501-2.467,5.501-5.5V9c0-0.551-0.448-1-1-1s-1,0.449-1,1v2.5    c0,0.276-0.224,0.5-0.5,0.5s-0.5-0.224-0.5-0.5V8c0-0.551-0.448-1-1-1s-1,0.449-1,1v3.5c0,0.276-0.224,0.5-0.5,0.5    s-0.5-0.224-0.5-0.5V7c0-0.551-0.448-1-1-1s-1,0.449-1,1v4.5c0,0.276-0.224,0.5-0.5,0.5s-0.5-0.224-0.5-0.5V2c0-0.551-0.448-1-1-1    s-1,0.449-1,1v12.5c0,0.173-0.09,0.334-0.237,0.425c-0.146,0.091-0.331,0.099-0.486,0.022l-3.473-1.736    C5.027,13.073,4.719,13,4.41,13z"></path>
                            </svg>
                            <span class="tg-visually-hidden">Normal</span>
                        </button>
                        <button class="btn btn-default mode" id="line">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 96 96" enable-background="new 0 0 96 96" xml:space="preserve">
                                <path d="M80.647,16.634c1.108,0.839,2.484,1.344,3.979,1.344c3.648,0,6.616-2.968,6.616-6.616c0-3.646-2.968-6.611-6.616-6.611  c-3.646,0-6.611,2.966-6.611,6.611c0,1.613,0.581,3.092,1.543,4.241L15.602,79.559c-1.147-0.958-2.623-1.536-4.232-1.536  c-3.646,0-6.611,2.966-6.611,6.611c0,3.648,2.966,6.616,6.611,6.616c3.648,0,6.616-2.968,6.616-6.616  c0-1.498-0.507-2.877-1.351-3.987L80.647,16.634z"></path>
                            </svg>
                            <span class="tg-visually-hidden">Ligne</span>
                        </button>
                        <button class="btn btn-default mode" id="pen">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                                <path d="M96.1,15.2L84.8,3.9c-1.8-1.9-5.1-1.9-6.9,0L4.3,77.4c-0.4,0.4-0.6,0.9-0.7,1.5L2.5,95c0,0.7,0.2,1.3,0.7,1.8    c0.4,0.4,1,0.7,1.6,0.7c0.1,0,0.1,0,0.2,0l16.1-1.2c0.6,0,1.1-0.3,1.5-0.7l73.5-73.5C98,20.2,98,17.1,96.1,15.2z M19.9,91.8    L7.3,92.7l0.9-12.6l2.7-2.7l11.7,11.7L19.9,91.8z M25.9,85.8L14.2,74.1l56.6-56.6l5.9,5.9l5.9,5.9L25.9,85.8z M92.8,18.9L85.7,26    L74,14.3l7.1-7.1c0.1-0.1,0.3-0.1,0.4,0l11.3,11.3C92.9,18.6,92.9,18.8,92.8,18.9z"></path>
                            </svg>
                            <span class="tg-visually-hidden">Crayon</span>
                        </button>
                        <button class="btn btn-default mode" id="text">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 100 100" style="enable-background:new 0 0 100 100;" xml:space="preserve">
                              <polygon
                                      points="2.5,2.5 2.5,31.8 21.5,31.8 21.5,21.5 40.5,21.5 40.5,78.5 28.8,78.5 28.8,97.5 71.2,97.5 71.2,78.5 59.5,78.5     59.5,21.5 78.5,21.5 78.5,31.8 97.5,31.8 97.5,2.5   "></polygon>
                            </svg>
                            <span class="tg-visually-hidden">Text</span>
                        </button>
                        <button class="btn btn-default mode" id="rect">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                              <path d="M94.94,21.786V4.915H78.069v5.619H21.812V4.915H4.94v16.871h5.619v56.256H4.94v16.873h16.871v-5.621h56.258v5.621H94.94   V78.042h-5.621V21.786H94.94z M83.694,10.54h5.619v5.621h-5.619V10.54z M10.565,10.54h5.621v5.621h-5.621V10.54z M16.187,89.288   h-5.621v-5.619h5.621V89.288z M89.313,89.288h-5.619v-5.619h5.619V89.288z M83.694,78.042h-5.625v5.627H21.812v-5.627h-5.625   V21.786h5.625v-5.625h56.258v5.625h5.625V78.042z"></path>
                            </svg>
                            <span class="tg-visually-hidden">Rectangle</span>
                        </button>
                        <button class="btn btn-default mode" id="img">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 100 100" enable-background="new 0 0 100 100" xml:space="preserve">
                              <path d="M94.94,21.786V4.915H78.069v5.619H21.812V4.915H4.94v16.871h5.619v56.256H4.94v16.873h16.871v-5.621h56.258v5.621H94.94   V78.042h-5.621V21.786H94.94z M83.694,10.54h5.619v5.621h-5.619V10.54z M10.565,10.54h5.621v5.621h-5.621V10.54z M16.187,89.288   h-5.621v-5.619h5.621V89.288z M89.313,89.288h-5.619v-5.619h5.619V89.288z M83.694,78.042h-5.625v5.627H21.812v-5.627h-5.625   V21.786h5.625v-5.625h56.258v5.625h5.625V78.042z"></path>
                            </svg>
                            <span class="tg-visually-hidden">Image</span>
                        </button>
                    </div>
                    <div class="edit-form-console">
                        <button class="btn btn-default mode " id="look_Console">
                            <svg fill="#000000" xmlns="http://www.w3.org/2000/svg"
                                 xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"
                                 viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">
                                <path d="M383,306.8H256c-14,0-25.4,11.4-25.4,25.4c0,14,11.4,25.4,25.4,25.4h127c14,0,25.4-11.4,25.4-25.4   C408.4,318.2,397,306.8,383,306.8z"></path>
                                <path d="M223.2,238L147,161.8c-9.9-9.9-26-9.9-35.9,0c-9.9,9.9-9.9,26,0,35.9l58.2,58.2L111,314.2c-9.9,9.9-9.9,26,0,35.9   c5,5,18,15,35.9,0l76.2-76.2C233.1,264,233.1,248,223.2,238z"></path>
                                <path d="M459.2,52.8H52.8C24.8,52.8,2,75.6,2,103.6v304.8c0,28,22.8,50.8,50.8,50.8h406.4c28,0,50.8-22.8,50.8-50.8V103.6   C510,75.6,487.2,52.8,459.2,52.8z M52.8,408.4V103.6h406.4l0,304.8H52.8z"></path>
                            </svg>
                            <span class="tg-visually-hidden">Console</span>
                        </button>
                        {{--<button class="btn btn-default mode " id="look_Iframe">--}}
                        {{--<svg fill="#000000" xmlns="http://www.w3.org/2000/svg"--}}
                        {{--xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px" y="0px"--}}
                        {{--viewBox="0 0 512 512" enable-background="new 0 0 512 512" xml:space="preserve">--}}
                        {{--<path d="M383,306.8H256c-14,0-25.4,11.4-25.4,25.4c0,14,11.4,25.4,25.4,25.4h127c14,0,25.4-11.4,25.4-25.4   C408.4,318.2,397,306.8,383,306.8z"></path>--}}
                        {{--<path d="M223.2,238L147,161.8c-9.9-9.9-26-9.9-35.9,0c-9.9,9.9-9.9,26,0,35.9l58.2,58.2L111,314.2c-9.9,9.9-9.9,26,0,35.9   c5,5,18,15,35.9,0l76.2-76.2C233.1,264,233.1,248,223.2,238z"></path>--}}
                        {{--<path d="M459.2,52.8H52.8C24.8,52.8,2,75.6,2,103.6v304.8c0,28,22.8,50.8,50.8,50.8h406.4c28,0,50.8-22.8,50.8-50.8V103.6   C510,75.6,487.2,52.8,459.2,52.8z M52.8,408.4V103.6h406.4l0,304.8H52.8z"></path>--}}
                        {{--</svg>--}}
                        {{--<span class="tg-visually-hidden">Iframe</span>--}}
                        {{--</button>--}}
                    </div>
                </div>

                <div class="d-flex justify-content-center align-items-start ">
                    <div id="options_text" class="form-inline text-center tg-hidden">
                        <label for="stroke">@lang('messages.size')</label>
                        <select class="form-control" id="stroke" name="text_fontSize">
                            <option value="6">6</option>
                            <option value="8">8</option>
                            <option value="10">10</option>
                            <option value="12">12</option>
                            <option value="14">14</option>
                            <option value="16">16</option>
                            <option value="18">18</option>
                            <option value="20">20</option>
                            <option value="22">22</option>
                            <option value="24">24</option>
                            <option value="26">26</option>
                            <option value="28">28</option>
                            <option value="30">30</option>
                            <option value="32">32</option>
                        </select>
                    </div>
                </div>
                <div class="tg-hidden" name="console" id="console"></div>
                <fieldset>
                    <legend><span id="form_title">{{$step->name}}</span></legend>
                    <form class="form-group mb-0 " enctype="multipart/form-data" name="form"
                          id="form" action="">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="libelle" class="col-form-label text-md-right">@lang('messages.label')</label>
                            <div class="input-group">
                                <input class="form-control" type="text" id="libelle" name="libelle">
                                @if ($errors->has('libelle'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('libelle') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description"
                                   class="col-form-label text-md-right">@lang('messages.description')</label>
                            <div class="input-group">
                                <textarea class="form-control" rows="5" id="description" name="description"></textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="priority"
                                   class="col-form-label text-md-right">@lang('messages.priority')</label>
                            <div class="input-group">
                                <select class="form-control" id="priority" name="priority">
                                    @forelse ($priorities as $key => $priority)
                                        <option value="{{$key}}">{{$priority}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">

                            <label for="context" class="col-form-label text-md-right">@lang('messages.context') </label>
                            <div class="input-group">
                                <textarea class="form-control" id="context" rows="2" name="context"></textarea>
                            </div>
                        </div>
                        <div class="mb-3">

                            <label for="state" class="col-form-label text-md-right">@lang('messages.step') </label>
                            <div class="input-group">
                                <select class="form-control" id="state" name="state">
                                    @forelse ($states as $key => $state)
                                        <option value="{{$key}}">{{$state}}</option>
                                    @empty

                                    @endforelse
                                </select>
                            </div>
                        </div>
                        {{--<div class="mb-3">--}}
                            {{--<div id="droparea"></div>--}}

                        {{--</div>--}}
                        {{--Dropzone Preview Template--}}
                        {{--<div id="preview" style="display: none;">--}}

                            {{--<div class="dz-preview dz-file-preview">--}}
                                {{--<div class="dz-image"><img data-dz-thumbnail/></div>--}}

                                {{--<div class="dz-details">--}}
                                    {{--<div class="dz-size"><span data-dz-size></span></div>--}}
                                    {{--<div class="dz-filename"><span data-dz-name></span></div>--}}
                                {{--</div>--}}
                                {{--<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span>--}}
                                {{--</div>--}}
                                {{--<div class="dz-error-message"><span data-dz-errormessage></span></div>--}}


                                {{--<div class="dz-success-mark">--}}

                                    {{--<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"--}}
                                         {{--xmlns="http://www.w3.org/2000/svg"--}}
                                         {{--xmlns:xlink="http://www.w3.org/1999/xlink"--}}
                                         {{--xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">--}}
                                        {{--<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->--}}
                                        {{--<title>Check</title>--}}
                                        {{--<desc>Created with Sketch.</desc>--}}
                                        {{--<defs></defs>--}}
                                        {{--<g id="Page-1" stroke="none" stroke-width="1" fill="none"--}}
                                           {{--fill-rule="evenodd" sketch:type="MSPage">--}}
                                            {{--<path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"--}}
                                                  {{--id="Oval-2" stroke-opacity="0.198794158" stroke="#747474"--}}
                                                  {{--fill-opacity="0.816519475" fill="#FFFFFF"--}}
                                                  {{--sketch:type="MSShapeGroup"></path>--}}
                                        {{--</g>--}}
                                    {{--</svg>--}}

                                {{--</div>--}}
                                {{--<div class="dz-error-mark">--}}

                                    {{--<svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1"--}}
                                         {{--xmlns="http://www.w3.org/2000/svg"--}}
                                         {{--xmlns:xlink="http://www.w3.org/1999/xlink"--}}
                                         {{--xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">--}}
                                        {{--<!-- Generator: Sketch 3.2.1 (9971) - http://www.bohemiancoding.com/sketch -->--}}
                                        {{--<title>error</title>--}}
                                        {{--<desc>Created with Sketch.</desc>--}}
                                        {{--<defs></defs>--}}
                                        {{--<g id="Page-1" stroke="none" stroke-width="1" fill="none"--}}
                                           {{--fill-rule="evenodd" sketch:type="MSPage">--}}
                                            {{--<g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474"--}}
                                               {{--stroke-opacity="0.198794158" fill="#FFFFFF"--}}
                                               {{--fill-opacity="0.816519475">--}}
                                                {{--<path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"--}}
                                                      {{--id="Oval-2" sketch:type="MSShapeGroup"></path>--}}
                                            {{--</g>--}}
                                        {{--</g>--}}
                                    {{--</svg>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                        {{--</div>--}}
                        {{--End of Dropzone Preview Template--}}
                        <div class="text-right">
                            <button class="btn btn-primary" disabled name="validate" id="validate"
                                    type="button">@lang('messages.save')</button>
                        </div>
            {{--</div>--}}
            </form>
            </fieldset>
        </div>
        </div>
    </section>
@endsection
<script type="text/javascript" src="{{ URL::asset('js/dropzone.js') }}"></script>
<script type="text/javascript" src="{{ URL::asset('js/script.js') }}"></script>

