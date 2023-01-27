@php
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
$action = Str::after(Request::route()->getName(), '.');
@endphp
<form action="{{route('warehouse.store')}}" method="post">
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
    @csrf
<div class="uk-margin">
    <input type="hidden" name="warehouse_form">
    <label class="uk-form-label" for="form-stacked-select">{{Str::upper('stock')}}</label>
    <select class="uk-select" id="form-stacked-select" name="warehouse_stock_id">
        <option value="" selected disabled>SELECT ...</option>

        @foreach ($data['stockList'] as $stock)
        <option value="{{$stock->stock_id}}" class="uk-input">
            {{$stock->stock_set['stock_name']}}
        </option>
        @endforeach

    </select>
</div>

@isset($data['warehouseModel'])
    @foreach ((array)$data['warehouseModel']['warehouse_inventory'] as $keyStock => $warehouseList)
            @if ($keyStock == 'setting_stock_case_size_id')
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">{{Str::upper('setting_stock_case_size_id')}}</label>
                    <select class="uk-select" id="form-stacked-select" name="form[warehouse][warehouse_stock_id]">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach ($data['settingModel']->setting_stock_case_size as $key_setting_stock_case_size =>
                        $item_setting_stock_case_size)
                        <option value="{{$key_setting_stock_case_size}}" class="uk-input">
                            {{$item_setting_stock_case_size['description']}}
                        </option>
                        @endforeach
                    </select>
                </div>
            @elseif($keyStock == 'status')
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-select">{{Str::upper($keyStock)}}</label>
                    <select class="uk-select" id="form-stacked-select" name="form[warehouse][{{$keyStock}}]">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach (Warehouse::WarehouseInventoryStatus() as $statusKey => $status)
                        <option value="{{$statusKey}}" class="uk-input">
                            {{$status}}
                        </option>
                        @endforeach
                    </select>
                </div>
            @else
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keyStock) }}</label>
                <input class="uk-input" type="number" name="form[warehouse][{{$keyStock}}]" value="">
            </div>
        @endif
    @endforeach
@endisset
</form>


{{-- <div class="">
    <h3>INVENTORY</h3>
        @php
           
            $storeModel = Store::Account('store_id',$data['userModel']->store_id)->first();
            $storeList = Store::List('root_store_id', $data['storeModel']->store_id)
            ->get();
           
        @endphp
    
        
        <input name="form[warehouse][warehouse_user_id]" value="{{$data['userModel']->user_id}}" hidden>
<input name="form[warehouse][warehouse_stock_id]"
    value="@isset($data['stockModel']->stock_id) {{$data['stockModel']->stock_id}} @endisset" hidden>

@isset($data['warehouseList'])
@foreach ($data['warehouseList']->get()->toArray() as $keyStockTransfer => $warehouseList)


@foreach ($warehouseList as $keystock => $stock)

@if ($keystock == 'warehouse_reference')
<div class="uk-margin">
    <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
    <input class="uk-input" type="text" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
</div>
@elseif($keystock == 'warehouse_price' || $keystock == 'warehouse_cost_override' || $keystock == 'warehouse_quantity')
<div class="uk-margin">
    <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
    <input class="uk-input" type="number" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]"
        value="{{$stock}}">
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
    <select class="uk-select" id="form-stacked-select" name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]"
        value="{{ old('') }}">
        <option value="" selected disabled>SELECT ...</option>

        @foreach (Warehouse::WarehouseCostType() as $key => $status)
        <option value="{{$status}}" class="uk-input" @if($key==$stock) selected @endif>
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
        <option value="{{$type}}" class="uk-input" @if($key==$stock) selected @endif>
            {{Str::upper($type)}}
        </option>
        @endforeach

    </select>
</div>
@elseif($keystock == 'warehouse_store_id')
<div class="uk-margin">
    <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
    <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock}}</a>
</div>
@elseif($keystock == 'warehouse_note' || $keystock == 'warehouse_description')
<div class="uk-margin">
    <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
    <div class="uk-form-controls">
        <textarea name="form[warehouse][{{$keyStockTransfer}}][{{$keystock}}]" class="uk-textarea" id="" cols="30"
            rows="10">{{$stock}}</textarea>
    </div>
</div>
@endif



@endforeach

@break

@endforeach
@endisset

</div> --}}
