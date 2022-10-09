@extends('layout.master')

@section('content')
    <div class="uk-padding-small">
        <a class="uk-button uk-button-default" href="{{ route('event.index') }}"><span uk-icon="icon: arrow-left"></span>{{ __('Back to events') }}</a>
    </div>
    <div class="header">
        <h1 class="uk-heading-line uk-text-center"><span>{{ __('Edit the event') }}</span></h1>
    </div>
    <div class="content uk-padding-small">
        @include('event.item_form', ['route_name' => 'event.update', 'method' => 'PUT'])
    </div>
@endsection


