@inject('addressModel', 'App\Models\Address')
@php
   
   $accountTypeList = [
        'Individual',
        'Business'
    ];

@endphp
<div class="uk-grid-small" uk-grid>
    
    <div class="uk-width-1-1">
        <select class="uk-select" name="account_holder_type">
            <option selected disabled>Type</option>
            @foreach ($accountTypeList as $accountType)
                <option value="{{$accountType}}">{{$accountType}}</option>
            @endforeach
        </select>
    </div>
    
    <div class="uk-width-1-1">
        <input class="uk-input" name="account_holder_name" type="text" placeholder="Name" autocomplete='off' size='4' type='text'>
    </div>
    
    <div class="uk-width-1-1">
        <input class="uk-input" name="bank_name" type="text" placeholder="Bank Name" autocomplete='off' size='4' type='text'>
    </div>

    <div class="uk-width-1-2@s">
        <input class="uk-input" name="account_number" type="text" placeholder="Account Number" autocomplete='off' size='20'>
    </div>
   
    <div class="uk-width-1-2@s">
        <input class="uk-input" name="routing_number" type="text" placeholder='Sort Code/Routing Number' size='2'>
    </div>
    
    <div class="uk-width-1-1">
        <select class="uk-select" name="country">
            <option selected disabled>Country</option>
            @foreach ($data['countryList'] as $key => $country)
                <option value="{{$key}}">{{$country['id']}} / {{$country['default_currency']}}</option>
            @endforeach
        </select>
    </div>

    <div class="uk-width-1-6@s">
       
    </div>
</div>



