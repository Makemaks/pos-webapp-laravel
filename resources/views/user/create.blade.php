@extends('layout.master')

@php

@endphp

@section('content')
    <form id="user-store" action="{{ route('user.store') }}" method="POST">
        @csrf
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
@endsection
