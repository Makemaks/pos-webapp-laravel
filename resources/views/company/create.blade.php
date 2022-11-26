@extends('layout.master')

@section('content')
    <form id="store-update" action="{{route('company.store')}}" method="POST">
        @csrf
        @include('company.partial.createPartial')
    </form>
@endsection