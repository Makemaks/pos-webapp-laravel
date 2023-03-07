@extends('layout.master')
@inject('orderModel', 'App\Models\Order')
@php
  
@endphp
@section('content')  
      @include('order.partial.showPartial')
@endsection
