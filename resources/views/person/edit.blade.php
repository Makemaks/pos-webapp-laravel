@extends('layout.master')

@push('scripts')
    <script src="{{asset('js/myapp.js')}}"></script> 
@endpush

@php

    use App\Models\Address;
    use App\Models\Account;
    use App\Models\User;
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


   
   <div>
        <h3>Account</h3>

      
            @php
                $userModel = User::find($data['personModel']->person_id);
                $data['accountModel'] = Account::find($userModel->user_account_id);
               
            @endphp 
            @include('account.partial.createPartial')
        
        
   </div>


    @php
        $data['addressList'] = Address::List('addresstable_id', $data['personModel']->person_id)->paginate(10);
    @endphp


    <div>
        <h3>Address</h3>
        @if($data['addressList'])
            @include('address.partial.indexPartial')
        @endif
    </div>

    <div>
        <h3>Options</h3>
        Get this from account table
    </div>

</form>
@endsection
