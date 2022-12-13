@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script>
@endpush

@php
    $route = Str::before(Request::route()->getName(), '.');
@endphp

@section('content')
   
@endsection
