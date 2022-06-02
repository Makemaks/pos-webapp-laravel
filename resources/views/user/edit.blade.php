@extends('layout.master')

@php

@endphp
@section('content')
    <form id="user-update" action="{{ route('user.update', $data['userModel']->user_id) }}" method="POST">
        @csrf
        @method('PATCH')
        @if ($errors->any())
            <div class="uk-alert-danger" uk-alert>
                <a class="uk-alert-close" uk-close></a>
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        @include('user.partial.createPartial')
    </form>
    @include('partial.modalPartial')
@endsection
