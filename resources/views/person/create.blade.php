@extends('layout.master')

@push('scripts')
    <script src="{{asset('js/myapp.js')}}"></script> 
@endpush

@inject('htmlControlType', 'App\Enums\HTMLControlType')
@inject('genderType', 'App\Enums\GenderType')
@inject('encryptionHelper', 'App\Helpers\EncryptionHelper')
@php
    $personType = ['Employee', 'Ex-Employee', 'Non-Employee'];
@endphp


@section('content')
<form method="POST" id="submitForm" action="{{ route('person.create') }}" class="uk-form-horizontal">
    @csrf
    <div class="">
        @include('person.partial.createPartial')
    </div>
</form>
@endsection
