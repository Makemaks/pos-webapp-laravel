@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form action="store.store" method="POST" enctype="multipart/form-data">
       @csrf
       @method('PATCH')
        @include('account.partial.createPartial')
   </form>
@endsection
