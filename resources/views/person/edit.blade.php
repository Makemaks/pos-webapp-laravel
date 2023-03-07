@extends('layout.master')

@push('scripts')
    <script src="{{asset('js/myapp.js')}}"></script> 
@endpush

@php
    $personType = ['Employee', 'Ex-Employee', 'Non-Employee'];
    $pageTipList = [
       
    ];

    $arrayButtonSlot = [       
        "submitForm" => 'push',
    ];

    $arrayButtonType = [         
        "form=",
    ];

   
@endphp


@section('content')
<form method="POST" id="submitForm" action="{{ route('person.update', $data['personModel']->person_id) }}" class="uk-form-horizontal">
    @csrf
    @method('PATCH')
    <div class="">
        @include('person.partial.createPartial')
    </div>
</form>
@endsection
