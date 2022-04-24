@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="store-update" action="{{route('user.store')}}" method="POST">
       @csrf
        @include('user.partial.createPartial')
   </form>
@endsection
