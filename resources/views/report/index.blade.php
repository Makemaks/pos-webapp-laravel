
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

        @include('report.partial.dropDownPartial')
        
        @include('partial.reportPartial' . $table)
        
        @if ($table !== '')
           
            <div class="uk-alert-danger uk-border-rounded" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>No data to display.</p>
            </div>
           
        @endif
      
    </form>
@endsection
