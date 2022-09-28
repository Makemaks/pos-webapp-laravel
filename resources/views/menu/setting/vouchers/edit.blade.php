@extends('layout.master')

@section('content')
    <form action="{{ route('setting.update', ['setting' => $data['settingModel']['setting_id']]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="index" value="{{ $index }}">
        @include('menu.setting.vouchers.item')
    </form>
@endsection


