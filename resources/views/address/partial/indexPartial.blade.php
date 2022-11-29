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
@endphp

<table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-responsive">
    <thead>
        <tr>
            <th></th>
            <th>REF</th>
                @isset($data['addressList'])
                    @foreach ($data['addressList']->toArray()[0] as $keystock => $item)
                        @if ($keystock != 'address_id' && $keystock != 'address_type' && $keystock != 'created_at' && $keystock != 'updated_at' && $keystock != 'address_geolocation' && $keystock != 'address_email' && $keystock != 'address_default' && $keystock != 'address_website' && $keystock != 'addresstable_type' && $keystock != 'address_delivery_type')
                            <th>{{Str::after($keystock, 'address_')}}</th>
                        @endif
                    @endforeach
                @endisset
            <th></th>
        </tr>
    </thead>
    <tbody>
        @isset($data['addressList'])
            @foreach ($data['addressList']->toArray() as $keyStockTransfer => $addressList)
                <tr>
                    <td>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <input class="uk-checkbox" type="checkbox"
                                    value="{{ $addressList['address_id'] }}"
                                    name="address_checkbox[]">
                            </div>
                        </div>
                    </td>
                    @foreach ($addressList as $keystock => $stock)
                        @if ($keystock == 'address_id')
                            <input class="uk-input" type="text" name="address[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}" hidden>
                            <td>
                                <button class="uk-button uk-button-default uk-border-rounded" onclick="">{{$stock}}</button>
                            </td>
                        @elseif ($keystock == 'address_line')
                            <td>
                                <input class="uk-input" type="text" name="address[{{$keyStockTransfer}}][{{$keystock}}][1]" value="{{$stock['1']}}">
                            </td>
                        @elseif ($keystock == 'address_town' || $keystock == 'address_county' || $keystock == 'address_country')
                            <td>
                                <input class="uk-input" type="text" name="address[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </td>
                        @elseif ($keystock == 'address_postcode')
                            <td>
                                <input class="uk-input" type="number" name="address[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </td>
                        @elseif ($keystock == 'addresstable_id')
                            <td>
                                <select class="uk-select" id="form-stacked-select" name="address[{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    @foreach ($storeList as $store)
                                        <option value="{{$store->store_id}}" class="uk-input" @if($store->store_id == $stock) selected @endif>
                                            {{$store->store_id}}
                                        </option>
                                    @endforeach
                                    
                                </select>
                            </td>
                        @elseif ($keystock == 'address_phone')
                            <td>
                                <input class="uk-input" placeholder="Phone" type="number" name="address[{{$keyStockTransfer}}][{{$keystock}}][1]"
                                value="{{ $stock['1'] }}">
                            </td>
                        @endif
                    @endforeach
                </tr>    
            @endforeach
        @endisset
    </tbody>
</table>