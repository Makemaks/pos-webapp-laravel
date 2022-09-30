@extends('layout.master')

@section('content')
    <form action="company.store" method="POST">
        @csrf
        @method('PATCH')
        @include('company.partial.createPartial')
    </form>
@endsection