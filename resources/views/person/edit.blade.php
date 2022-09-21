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
<form method="POST" id="person-update" action="{{ route('person.update', $data['personModel']->person_id) }}" class="uk-form-horizontal">
    @csrf
    @method('PATCH')
    <div class="">
        @include('person.partial.createPartial')
    </div>
    <div>
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
  

    </div>

    <div>
        <fieldset>
            <legend>Contact Details:</legend>
            <label class="uk-form-label" for="form-stacked-text">Phone 1</label>
            <div class="uk-form-controls uk-padding-small">
                <input type="text" class="uk-input uk-form-small" name="phone_no[]" id="phone_no" value="{{ old('address_email[]') }}"></input>
            </div>
            <label class="uk-form-label" for="form-stacked-text">Phone 2</label>
            <div class="uk-form-controls uk-padding-small">
                <input type="text" class="uk-input uk-form-small" name="phone_no[]" id="phone_no" value="{{ old('address_email[]') }}"></input>
            </div>
            <label class="uk-form-label" for="form-stacked-text">Phone 3</label>
            <div class="uk-form-controls uk-padding-small">
                <input type="text" class="uk-input uk-form-small" name="phone_no[]" id="phone_no" value="{{ old('address_email[]') }}"></input>
            </div>
            <label class="uk-form-label" for="form-stacked-text">Email</label>
            <div class="uk-form-controls uk-padding-small">
                <input type="email" class="uk-input uk-form-small" name="email" id="person_dob" value="{{ old('address_email[]') }}"></input>
            </div>
        </fieldset>

    </div>



    <button class="uk-button uk-button-default uk-align-right" type="submit">Update</button>

</form>
@endsection
