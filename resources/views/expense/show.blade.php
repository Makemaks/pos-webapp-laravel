@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form action="reservation.update" method="POST">
       @csrf
       @method('PATCH')
        @include('reservation.partial.createPartial')
   </form>
@endsection
