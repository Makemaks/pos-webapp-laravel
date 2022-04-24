@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="store-update" action="{{route('store.update', $data['storeModel'])}}" method="POST">
       @csrf
       @method('PATCH')
       <div class="">
         @include('store.partial.createPartial')
       </div>
   </form>
@endsection
