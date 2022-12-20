
@extends('layout.master')

@php
    $route = Str::before(Request::route()->getName(), '.');
    if ($data['table'] !== '') {
        $table = $data['table'];
    } else {
        $table = '';
    }
@endphp


@section('content')
    <form action="{{ route($route . '.index') }}" method="GET">
        {{Session::get('report')}}
        @include('report.partial.dropDownPartial')
        @include('report.partial.pages.' . Session::get('report'))
       
        @if ($table !== '')
           
            <div class="uk-alert-danger uk-border-rounded" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>No data to display.</p>
            </div>
           
        @endif
      
    </form>
@endsection
