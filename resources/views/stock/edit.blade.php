@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form action="stock.store" method="POST">
       @csrf
        @include('stock.partial.createPartial')
   </form>

  
@endsection
