@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form action="user.store" method="POST">
       @csrf
       @method('PATCH')
        @include('user.partial.createPartial')
   </form>
@endsection
