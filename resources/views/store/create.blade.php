@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="store-update" enctype="multipart/form-data" action="{{route('store.store')}}" method="POST">
       @csrf
        @include('store.partial.createPartial')
   </form>
@endsection
