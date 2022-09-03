@extends('layout.master')

@section('content')
    <form action="{{ route('setting.update', ['setting' => $data['settingModel']['setting_id']]) }}" method="POST">
        @csrf
        @method('PUT')
        @include('menu.partial.createPartial')
    </form>
@endsection
