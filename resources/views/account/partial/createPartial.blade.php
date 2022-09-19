<fieldset class="uk-fieldset">

    <legend class="uk-legend">{{$data['accountModel']->account_name}}</legend>

    <div class="uk-margin">
        <img src="{{$data['accountModel']->account_image}}" alt="" width="200" height="100">
    </div>

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Name" name="account_name" value="{{ old('account_name', $data['accountModel']->account_name ) }}"/>
    </div>
    @error('account_name')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Location" name="account_location" value="{{ old('account_location', $data['accountModel']->account_location ) }}"/>
    </div>
    @error('account_location')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Vat" name="account_vat" value="{{ old('account_vat', $data['accountModel']->account_vat ) }}"/>
    </div>
    @error('account_vat')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror

    <div class="uk-margin">
        <input class="uk-input" type="text" placeholder="Business Hours" name="account_business_hours" value="{{ old('account_business_hours', $data['accountModel']->account_business_hours ) }}"/>
    </div>
    @error('account_business_hours')
        <div class="uk-text-danger">{{ $message }}</div>
    @enderror


   @if ($data['accountList'] && count($data['accountList']) > 0)
        <div class="uk-margin">
            <label for="">
                <input class="uk-checkbox" type="checkbox" name="account_is_main" value="{{ old('account_is_main') }}"/>
                Main
            </label>
        </div>
        @error('account_is_main')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
   @endif

</fieldset>
