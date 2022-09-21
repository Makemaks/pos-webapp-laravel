@extends('layout.master')

@push('scripts')
    <script src="{{asset('js/myapp.js')}}"></script> 
@endpush

@php

    use App\Models\Address;
    use App\Models\Account;
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


    @if ($data['personModel']->user_account_id)
        @php
            $data['accountModel'] = Account::find($data['personModel']->user_account_id);
        @endphp 
        <h3>Account</h3>
        @include('account.partial.createPartial')
    @endif


    @php
        $data['addressList'] = Address::List('addresstable_id', $data['personModel']->person_id)->paginate(10);
    @endphp



    @if($data['addressList'])

        <h3>Address</h3>
        @include('address.partial.indexPartial')
    @endif

    <div>
        <h3>Options</h3>
    </div>

</form>
@endsection
