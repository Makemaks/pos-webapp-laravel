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
        @foreach ($data['addressList']->toArray() as $addressListKey => $addressList)
            @foreach ($addressList as $addressKey => $addressItem)
                    @if($addressKey == 'addresstable_id')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($addressKey, '_') }}<label class="red">*</label></label>
                            <select class="uk-select" id="form-stacked-select" name="{{$addressKey}}">
                                <option value="" selected disabled>SELECT ...</option>
                                
                                    @foreach ($storeList as $store)
                                        <option value="{{$store->store_id}}" class="uk-input" @if($store->store_id == $addressItem) selected @endif>
                                            {{$store->store_name}}
                                        </option>
                                    @endforeach
                                
                            </select>
                        </div>
                    @elseif($addressKey == 'address_delivery_type')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($addressKey, '_' )) }}<label class="red">*</label></label>
                            <select class="uk-select" id="form-stacked-select" name="{{$addressKey}}">
                                <option value="" selected disabled>SELECT ...</option>
                                @foreach (Address::AddressType() as $key => $type)
                                    <option value="{{$key}}" class="uk-input" @if($key == $addressItem) selected @endif>
                                        {{Str::upper($type)}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($addressKey == 'addresstable_type')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($addressKey, '_') }}<label class="red">*</label></label>
                            <select class="uk-select" id="form-stacked-select" name="{{$addressKey}}">
                                <option value="" selected disabled>SELECT ...</option>
                                @foreach ($storeList as $store)
                                    <option value="{{$store->store_name}}" class="uk-input" @if($store->store_name == $addressItem) selected @endif>
                                        {{$store->store_name}}
                                    </option>
                                @endforeach
                                
                            </select>
                        </div>
                    @else
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($addressKey, '_' ) }}</label>
                            @if (is_array($addressItem))
                                @foreach ($addressItem as $a)
                                    <input class="uk-input" type="text" name="{{$addressKey}}" value="{{$a}}">
                                @endforeach
                            @else
                                <input class="uk-input" type="text" name="{{$addressKey}}" value="{{$addressItem}}">
                            @endif
                        </div>
                    @endif
            @endforeach
                
        @break

        @endforeach
   @endisset    
</div>