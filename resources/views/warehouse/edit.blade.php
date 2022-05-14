@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form action="warehouse.store" method="POST">
       @csrf
       @method('PATCH')
        @include('warehouse.partial.createPartial')
   </form>
@endsection
