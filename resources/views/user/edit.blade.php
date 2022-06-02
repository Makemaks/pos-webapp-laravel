@extends('layout.master')

@php

@endphp
@section('content')
    <form id="user-update" action="{{ route('user.update', $data['userModel']->user_id) }}" method="POST">
        @csrf
        @method('PATCH')
        @include('user.partial.createPartial')
    </form>
    @include('partial.modalPartial')
@endsection
