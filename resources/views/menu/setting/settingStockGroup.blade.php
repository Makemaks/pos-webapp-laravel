@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
use App\Models\Setting;
use App\Models\Project;
@endphp

@section('content')
   @include('menu.partial.crudPartial')
   <form id="settingUpdate" action="{{route('setting.update', $data['settingModel']->setting_id)}}" method="POST">
        @csrf
        @method('PATCH')
        
        @include('menu.partial.SettingStockSetPartial')
   </form>
@endsection


