@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
    use App\Models\Setting;
    use App\Models\Project;
    use App\Models\Stock;
@endphp

@section('content')
    <h3>{{Str::upper(Request::get('view'))}}</h3>
@endsection


