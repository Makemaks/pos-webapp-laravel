@extends('layout.master')


@section('content')
    <form id="mainForm" enctype="multipart/form-data" action="{{ route('setting.store') }}" method="POST">
        @csrf
        @include('setting.partial.createPartial')
    </form>

@endsection