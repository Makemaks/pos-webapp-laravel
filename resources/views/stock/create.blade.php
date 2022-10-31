@extends('layout.master')

@php
    $action = Str::after(Request::route()->getName(), '.');
    $active = '';

    if ($action == 'create') {
        $active = "active: 1";
    }
@endphp

@section('content')    
   <form id="stock-store" action="{{route('stock.store')}}" enctype="multipart/form-data" method="POST">
       @csrf
        @include('stock.partial.createPartial')
    </form>
@endsection
