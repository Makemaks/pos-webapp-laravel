@extends('layout.master')

@section('content')
    <form id="editForm" enctype="multipart/form-data" action="{{ route('setting.update',$data['settingModel']->setting_id) }}" method="POST">
        @method('PUT')
        @csrf
        @include('setting.partial.createPartial')
    </form>

@endsection