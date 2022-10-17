
@extends('layout.master')

@php
    $route = Str::before(Request::route()->getName(), '.');
   
@endphp


@section('content')
    <form action="{{ route('report.index') }}" method="GET">

        @include('report.partial.reportSelectPartial')
        @include('partial.reportPartial')
       
        
        @if ( Session::has('report') )
            @include( 'report.'. Session::get('report') )
        @else
            <div class="uk-alert-danger uk-border-rounded" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                <p>No data to display.</p>
            </div>
        @endif
       
      
    </form>
@endsection
