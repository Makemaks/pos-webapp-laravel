@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="store-update" action="{{route('store.store')}}" method="POST">
       @csrf
       <div class="">
            @include('store.partial.createPartial')
       </div>
   </form>
@endsection
