@extends('layout.master')

@php
  
@endphp
@section('content')    
        <form action="{{route('setting.store')}}" method="POST">
                @csrf
                @include('setting.partial.createPartial')
        </form>
@endsection
