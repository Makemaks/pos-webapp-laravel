@extends('layout.master')

@section('content')
    <form id="store-update" action="{{route('company.update', ['company' => $data['companyModel']['company_id']])}}" method="POST">
        @csrf
        @method('PUT')
        @include('company.partial.createPartial')
    </form>
@endsection
