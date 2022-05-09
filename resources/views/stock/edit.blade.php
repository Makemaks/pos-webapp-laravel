@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="stock-update" action="{{route('stock.update', $data['stockModel']->stock_id)}}" method="POST">
       @csrf
       @method('PATCH')
       @include('stock.partial.createPartial')
   </form>

  
@endsection
