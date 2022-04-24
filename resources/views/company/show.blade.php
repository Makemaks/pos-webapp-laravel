@extends('layout.master')

@inject ('personModel', 'App\Models\Person')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')

@section('content')
    <div> @include('contact.partial.menuPartial')</div>
    <div class="">
        @include('company.partial.createPartial')
    </div>
@endsection