@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
    use App\Models\Setting;
@endphp

@section('content')
    @include('menu.partial.settingApiPartial')
@endsection