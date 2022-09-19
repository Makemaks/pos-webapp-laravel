@extends('layout.master')

@php
  
@endphp
@section('content')    
   <form id="account-update" action="{{route('account.update', $data['accountModel'])}}" method="POST">
       @csrf
       @method('PATCH')
       <div class="uk-container uk-container-xsmall">
         @include('account.partial.createPartial')
       </div>
   </form>
@endsection
