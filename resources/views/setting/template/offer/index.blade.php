@extends('layout.master')

@section('content')
    <div>
        <div uk-grid>
            <div class="uk-width-auto@m">
                <ul class="uk-tab-left" uk-tab="connect: #component-tab-left; animation: uk-animation-fade">
                    <li><a href="#">First</a></li>
                    <li><a href="#">Second</a></li>
                </ul>
            </div>
            <div class="uk-width-expand@m">
                <ul id="component-tab-left" class="uk-switcher">
                    <li>
                        <div>
                            <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-fade">
                                <li><a href="#">Light</a></li>
                                <li><a href="#">Dark</a></li>
                                <li><a href="#">Primary</a></li>
                            </ul>
                            <ul class="uk-switcher uk-margin">
                                <li>@include('setting.template.offer.templates.first_light')</li>
                                <li>@include('setting.template.offer.templates.first_dark')</li>
                                <li>@include('setting.template.offer.templates.first_primary')</li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <div>
                            <ul class="uk-subnav uk-subnav-pill" uk-switcher="animation: uk-animation-fade">
                                <li><a href="#">Light</a></li>
                                <li><a href="#">Dark</a></li>
                                <li><a href="#">Primary</a></li>
                            </ul>

                            <ul class="uk-switcher uk-margin">
                                <li>@include('setting.template.offer.templates.second_light')</li>
                                <li>@include('setting.template.offer.templates.second_dark')</li>
                                <li>@include('setting.template.offer.templates.second_primary')</li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
