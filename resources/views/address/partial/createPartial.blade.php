
<div class="uk-container uk-container-xsmall">
    <input type="hidden" name="addresstable_id" value="{{old('addresstable_id', $data['addressModel']->addresstable_id)}}">
    <input type="hidden" name="addresstable_type" value="{{old('addresstable_type', $data['addressModel']->addresstable_type)}}">


    <div>           
        <h3>Address</h3>
        <div class="uk-margin">
            <label for="address-line-1" class="w3-text-gray">Address Line 1 <span
                        class="w3-text-red">*</span></label>
                <input type="text" class="uk-input" name="address_line_1" id="address-line-1"
                    value="{{ old('address_line_1', $data['addressModel']->address_line_1) }}"/>
                @error('line_1')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="address-line-2" class="w3-text-gray">Address Line 2</label>
            
                <input type="text" class="uk-input" name="address_address_line_2" id="address-line-2"
                    value="{{ old('address_line_2', $data['addressModel']->address_line_2) }}"/>
                @error('address_line_2')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="address-line-3" class="w3-text-gray">Address Line 3</label>
            
                <input type="text" class="uk-input" name="address_address_line_3" id="address-line-3"
                    value="{{ old('address_line_3', $data['addressModel']->address_line_3) }}"/>
                @error('address_line_3')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="town" class="w3-text-gray">Town / City <span class="w3-text-red">*</span></label>
            
                <input type="text" class="uk-input" name="address_town" id="town" value="{{ old('address_town', $data['addressModel']->address_town) }}"/>
                @error('address_town')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="county" class="w3-text-gray">County</label>
            
                <input type="text" class="uk-input" name="address_county" id="county" value="{{ old('address_county', $data['addressModel']->address_county) }}"/>
                @error('address_county')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="postcode" class="w3-text-gray">Postcode <span class="w3-text-red">*</span></label>
            
                <input type="text" class="uk-input" name="address_postcode" id="postcode"
                    value="{{ old('address_postcode', $data['addressModel']->address_postcode) }}"/>
                @error('address_postcode')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="country" class="w3-text-gray">Country <span class="w3-text-red">*</span></label>
            
                <input type="text" class="uk-input" name="address_country" id="country"
                    value="{{ old('address_country', $data['addressModel']->address_country) }}"/>
                @error('address_country')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="phone_1" class="w3-text-gray">Telephone 1<span class="w3-text-red">*</span></label>
            
                <input type="text" class="uk-input" name="address_phone_1" id="phone_1" value="{{ old('address_phone_1', $data['addressModel']->address_phone_1) }}"/>
                @error('address_phone_1')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="phone_2" class="w3-text-gray">Telephone 2 </label>
            
                <input type="text" class="uk-input" name="address_phone_2" id="phone_2" value="{{ old('address_phone_2', $data['addressModel']->address_phone_2) }}"/>
                @error('address_phone_2')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="email_1" class="w3-text-gray">Email Address 1<span class="w3-text-red">*</span></label>
            
                <input type="text" class="uk-input" name="address_email_1" id="email" value="{{ old('address_email_1', $data['addressModel']->address_email_1) }}"/>
            @error('address_email_1')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="email_2" class="w3-text-gray">Email Address 2 </label>
            
                <input type="text" class="uk-input" name="address_email_2" id="email" value="{{ old('address_email_2', $data['addressModel']->address_email_2) }}"/>
            @error('address_email_2')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="website_1" class="w3-text-gray">website_1 <span class="w3-text-red">*</span></label>
        
            <input type="text" class="uk-input" name="address_website_1" id="website_1"
                value="{{ old('address_website_1', $data['addressModel']->address_website_1) }}"/>
            @error('address_website_1')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>

        <div class="uk-margin">
            <label for="website_1" class="w3-text-gray">Website 2 </label>
        
            <input type="text" class="uk-input" name="address_website_1" id="website_1"
                value="{{ old('address_website_2', $data['addressModel']->address_website_2) }}"/>
            @error('address_website_2')
                <div class="w3-text-red">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>