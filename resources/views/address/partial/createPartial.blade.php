@php
    use App\Models\Address;
    $data['addressModel'] = new Address();
@endphp

<div class="uk-container uk-container-xsmall">
    <input type="hidden" name="addresstable_id" value="{{old('addresstable_id' , $data['addressModel']->addresstable_id)}}">
    <input type="hidden" name="addresstable_type" value="{{old('addresstable_type' , $data['addressModel']->addresstable_type)}}">


   
    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="line-1">Address<label class="w3-text-theme">*</label></label>
            </ons-col>
            
            <ons-col>
                <ons-input type="text" name="address_line" id="address_line" value="{{ old('address_line' , $data['userModel']->address_line) }}"></ons-input>
                @error('address_line')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>

    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="town">Town / City <label class="w3-text-theme">*</label></label>
            </ons-col>
            
            <ons-col>
                <ons-input type="text" name="address_town" id="address_town" value="{{ old('address_town' , $data['userModel']->address_town) }}"></ons-input>
                @error('address_town')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>

    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="county">County</label>
            </ons-col>
            
            <ons-col>
                <ons-input type="text" name="address_county" id="address_county" value="{{ old('address_county' , $data['userModel']->address_county) }}"></ons-input>
                @error('address_county')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>

    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="postcode">Postcode<label class="w3-text-theme">*</label></label>
            </ons-col>
            
            <ons-col>
                <ons-input type="text" name="address_postcode" id="postcode" value="{{ old('address_postcode' , $data['userModel']->address_postcode) }}" placeholder="NZ1 5PJ"></ons-input>
                @error('address_postcode')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>

    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="country">Country<label class="w3-text-theme">*</label></label>
            </ons-col>
            
            <ons-col>
                <ons-input type="text" name="address_country" id="country" value="{{ old('address_country' , $data['userModel']->address_country) }}"></ons-input>
                @error('address_country')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror 
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>
    
    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="phone">Telephone Number</label>
            </ons-col>
            
            <ons-col>
                <ons-input type="text" name="address_phone" id="address_phone" value="{{ old('address_phone' , $data['userModel']->address_phone) }}"></ons-input>
                @error('address_phone')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>
   
    {{-- <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="email">Email Address</label>
            </ons-col>
           
            <ons-col>
                <ons-input type="text" name="address_email" id="address_email" value="{{ old('address_email' , $data['userModel']->address_email) }}"></ons-input>
                @error('address_email')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>

    <div class="w3-section">
        <ons-row>
            <ons-col width="150px">
                <label for="phone">Website</label>
            </ons-col>

            <ons-col>
                <ons-input type="text" name="address_website" id="address_website" value="{{ old('address_website' , $data['userModel']->address_website) }}"></ons-input>
                @error('address_website')
                    <div class="w3-text-theme">{{ $message }}</div>
                @enderror
           </ons-col>
          
            <div class="w3-border-bottom w3-width-100"></div>
           
        </ons-row>
    </div>
 --}}
</div>