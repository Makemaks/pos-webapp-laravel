@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="store-update" action="{{route('warehouse.store')}}" method="POST">
       @csrf
        @include('warehouse.partial.createPartial')
   </form>
@endsection
