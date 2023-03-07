@extends('layout.master')
@inject('orderModel', 'App\Models\Order')
@section('content')  
    @include('order.partial.tillIndexPartial')
@endsection
