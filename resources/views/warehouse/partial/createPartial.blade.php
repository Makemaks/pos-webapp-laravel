@php
    use App\Models\Warehouse;
    use App\Models\User;
    use App\Models\Store;
    $action =  Str::after(Request::route()->getName(), '.');
@endphp



<div class="">
    <h3>TRANSFERS</h3>
    

        @php
           
            $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
            $storeList = Store::List('root_store_id', $data['storeModel']->store_id)
            ->get();
          
        @endphp
    
        
        <input name="form[warehouse][warehouse_user_id]" value="{{$data['userModel']->user_id}}" hidden>
        <input name="form[warehouse][warehouse_stock_id]" value="{{$data['stockModel']->stock_id}}" hidden>
        
       @isset($data['warehouseList'])
            @foreach ($data['warehouseList']->toArray() as $keyStockTransfer => $warehouseList)
                        
            
                @foreach ($warehouseList as $keystock => $stock)

                        @if ($keystock == 'warehouse_reference')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="text" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'warehouse_price' || $keystock == 'warehouse_quantity')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="number" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'warehouse_store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($storeList as $store)
                                            <option value="{{$store->store_id}}" class="uk-input" @if($store->store_id == $stock) selected @endif>
                                                {{$store->store_name}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'warehouse_status')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]" value="{{ old('') }}">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Warehouse::WarehouseStatus() as $key => $status)
                                            <option value="{{$status}}" class="uk-input" @if($key == $stock) selected @endif>
                                                {{Str::upper($status)}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'warehouse_type')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Warehouse::WarehouseType() as $key => $type)
                                            <option value="{{$type}}" class="uk-input" @if($key== $stock) selected @endif>
                                                {{Str::upper($type)}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </div>
                        @elseif($keystock == 'warehouse_store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-danger uk-border-rounded">{{$stock}}</a>
                            </div>
                        @elseif($keystock == 'warehouse_note' || $keystock == 'warehouse_description')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <div class="uk-form-controls">
                                    <textarea name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]" class="uk-textarea" id="" cols="30" rows="10">{{$stock}}</textarea>
                                </div>
                            </div>
                        @endif

                        
                        
                @endforeach
                    
            @break
    
            @endforeach
       @endisset

   
    
</div>

