@extends('layout.master')

@php
    use App\Models\Setting;
@endphp

@section('content')

    @include('menu.partial.crudPartial')
    @include('setting.partial.settingKeyPartial')
@endsection


