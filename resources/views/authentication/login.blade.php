@extends('layout.master')
@php
  
@endphp

@section('content')

<div class="uk-align-center">
    <form method="GET" action="{{ route('authentication.login') }}">
        @csrf
       @include('authentication.partial.loginPartial')
    </form>
</div>


@endsection
