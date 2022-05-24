@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="stock-store" action="{{route('stock.store')}}" method="POST">
       @csrf
        @include('stock.partial.createPartial')
   </form>
@endsection
