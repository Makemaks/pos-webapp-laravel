@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form action="store.store" method="POST" enctype="multipart/form-data">
       @csrf
       @method('PATCH')
        @include('store.partial.createPartial')
   </form>
@endsection
