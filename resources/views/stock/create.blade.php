@extends('layout.master')

@php
    $route = Str::after(Request::route()->getName(), '.');
    $active = '';

    if ($route == 'create') {
        $active = "active: 1";
    }
@endphp

@section('content')    
   <form id="stock-store" action="{{route('stock.store')}}" method="POST">
       @csrf
        @include('stock.partial.createPartial')
    </form>
@endsection
