@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="stock-update" action="{{route('stock.store')}}" method="POST">
       @csrf
        @include('stock.partial.createPartial')
   </form>
@endsection
