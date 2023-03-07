@extends('layout.master')
@php
  
@endphp
@section('content')    
  @include('reservation.partial.menuPartial')

  <div class="uk-container uk-container-xsmall">
      @include('reservation.partial.createPartial')
  </div>
@endsection
