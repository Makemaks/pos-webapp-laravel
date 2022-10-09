@extends('layout.master')

@section('content')
    <div class="uk-padding-small">
        <a class="uk-button uk-button-default" href="{{ route('event.index') }}"><span uk-icon="icon: arrow-left"></span>{{ __('Back to events') }}</a>
    </div>
    <div class="header">
        <h1 class="uk-heading-line uk-text-center"><span>{{ __('Create a new event') }}</span></h1>
    </div>
    <div class="content uk-padding-small">
        @include('event.item_form', ['event' => null, 'route_name' => 'event.store'])
    </div>
@endsection


