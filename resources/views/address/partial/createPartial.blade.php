@php
use App\Models\Address;
use App\Models\User;
use App\Models\Store;
$action =  Str::after(Request::route()->getName(), '.');
@endphp

<div class="">
<h3>ADDRESS</h3>

    @php
        $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
        $storeList = Store::List('store_id', $data['storeModel']->store_id)
        ->get();
      
    @endphp

    @isset($data['addressList'])
        <input type="hidden" name="address_default" value="0"/>
        @foreach ($data['addressList']->toArray() as $keyStockTransfer => $addressList)
            @foreach ($addressList as $keystock => $stock)
                    @if ($keystock == 'address_line')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_' ) }}<label class="red">*</label></label>
                            <input class="uk-input" type="text" name="{{$keystock}}[1]" value="{{$stock['1']}}">
                        </div>
                    @elseif ($keystock == 'address_town' || $keystock == 'address_county' || $keystock == 'address_country')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}<label class="red">*</label></label>
                            <input class="uk-input" type="text" name="{{$keystock}}" value="{{$stock}}">
                        </div>
                    @elseif($keystock == 'address_postcode')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}<label class="red">*</label></label>
                            <input class="uk-input" type="number" name="{{$keystock}}" value="{{$stock}}">
                        </div>
                    @elseif($keystock == 'address_geolocation')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}_LATITUDE</label>
                            <input type="number" step="any" name="{{$keystock}}[latitude]" class="uk-input" placeholder="Latitude" value="{{ $stock['latitude'] }}">
                        </div>
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}_LONGITUDE</label>
                            <input type="number" step="any" name="{{$keystock}}[longitude]" class="uk-input" placeholder="Longitude" value="{{ $stock['longitude'] }}" >
                        </div>
                    @elseif($keystock == 'addresstable_id')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_') }}<label class="red">*</label></label>
                            <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                <option value="" selected disabled>SELECT ...</option>
                                
                                    @foreach ($storeList as $store)
                                        <option value="{{$store->store_id}}" class="uk-input" @if($store->store_id == $stock) selected @endif>
                                            {{$store->store_name}}
                                        </option>
                                    @endforeach
                                
                            </select>
                        </div>
                    @elseif($keystock == 'address_delivery_type')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}<label class="red">*</label></label>
                            <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                <option value="" selected disabled>SELECT ...</option>
                                @foreach (Address::AddressType() as $key => $type)
                                    <option value="{{$key}}" class="uk-input" @if($key == $stock) selected @endif>
                                        {{Str::upper($type)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($keystock == 'addresstable_type')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_') }}<label class="red">*</label></label>
                            <select class="uk-select" id="form-stacked-select" name="{{$keystock}}">
                                <option value="" selected disabled>SELECT ...</option>
                                
                                @foreach ($storeList as $store)
                                    <option value="{{$store->store_name}}" class="uk-input" @if($store->store_name == $stock) selected @endif>
                                        {{$store->store_name}}
                                    </option>
                                @endforeach
                                
                            </select>
                        </div>
                    @elseif ($keystock == 'address_phone')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_' ) }}</label>
                            <input class="uk-input" type="text" name="{{$keystock}}[1]" value="{{$stock['1']}}">
                        </div>
                    @elseif ($keystock == 'address_email')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_' ) }}</label>
                            <input class="uk-input" type="text" name="{{$keystock}}[1]" value="{{$stock['1']}}">
                        </div>
                    @elseif ($keystock == 'address_website')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keystock, '_' ) }}</label>
                            <input class="uk-input" type="text" name="{{$keystock}}[1]" value="{{$stock['1']}}">
                        </div>
                    @endif
            @endforeach
                
        @break

        @endforeach
   @endisset    
</div>