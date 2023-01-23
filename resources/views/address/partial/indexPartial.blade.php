@inject ('addressModel', 'App\Models\address')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')
@php
    use App\Models\Address;
    use App\Models\Stock;
    use App\Models\Store;
    use Carbon\Carbon;
   
    $addressList = new Stock();
    $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
    $storeList = Store::List('store_id', $data['storeModel']->store_id)->get();

    $array = [
        'address_id',
        'address_type',
        'created_at',
        'updated_at',
        'address_geolocation',
        'address_email',
        'address_default',
        'address_website',
        'addresstable_type',
        'address_delivery_type'
    ]; 
@endphp

<table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-responsive">
    <thead>
        <tr>
            <th></th>
            <th>REF</th>
                @isset($data['addressList'])
                    @foreach ($data['addressList']->toArray()[0] as $addressKey => $addressItem)
                        @if (array_search($addressKey, $array))
                            <th>{{Str::after($addressKey, 'address_')}}</th>
                        @endif
                    @endforeach
                @endisset
            <th></th>
        </tr>
    </thead>
    <tbody>
        @isset($data['addressList'])
            @foreach ($data['addressList']->toArray() as $addresListKey => $addressList)
                <tr>
                    <td>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <input class="uk-checkbox" type="checkbox" value="{{ $addressList['address_id'] }}" name="address_checkbox[]">
                            </div>
                        </div>
                    </td>
                    @foreach ($addressList as $addressKey => $addressItem)
                        @if (array_search($addressKey, $array))
                            
                            @if ($addressKey == 'address_id')
                                <td>
                                    <input class="uk-input" type="text" name="address[{{$addresListKey}}][{{$addressKey}}]" value="{{$addressItem}}" hidden>
                                    <button class="uk-button uk-button-default uk-border-rounded" onclick="">{{$addressItem}}</button>
                                </td>
                            @elseif ($addressKey == 'addresstable_id')
                                <td>
                                    <select class="uk-select" id="form-stacked-select" name="address[{{$addresListKey}}][{{$addressKey}}]">
                                        <option value="" selected disabled>SELECT ...</option>
                                        @foreach ($storeList as $store)
                                            <option value="{{$store->store_id}}" class="uk-input" @if($store->store_id == $addressItem) selected @endif>
                                                {{$store->store_id}}
                                            </option>
                                        @endforeach
                                        
                                    </select>
                                </td>
                            @else
                                <td>
                                    @if (is_array($addressItem))
                                        @foreach ($addressItem as $a)
                                            <input class="uk-input" type="text" name="address[{{$addresListKey}}][{{$addressKey}}][]" value="{{$a}}">
                                        @endforeach
                                    @else
                                        <input class="uk-input" type="text" name="address[{{$addresListKey}}][{{$addressKey}}][]" value="{{$addressItem}}">
                                    @endif
                                </td>
                            @endif
                        @endif
                    @endforeach
                </tr>    
            @endforeach
        @endisset
    </tbody>
</table>