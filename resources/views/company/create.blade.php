@extends('layout.master')

@inject ('personModel', 'App\Models\Person')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')

@section('content')
    @include('company.partial.createPartial')
@endsection