@php
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
$action = Str::after(Request::route()->getName(), '.');
@endphp
<form action="{{route('warehouse.store')}}" method="post">
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
    <input type="hidden" name="warehouse_id" value="{{$warehouseData->warehouse_id}}">
    <input type="hidden" name="is_update_request" >
    @csrf
<div class="uk-margin">
    <input type="hidden" name="warehouse_form">
    <label class="uk-form-label" for="form-stacked-select">{{Str::upper('stock')}}</label>
    <select class="uk-select" id="form-stacked-select" name="warehouse_stock_id">
        <option value="" selected disabled>SELECT ...</option>
        @foreach ($data['stockList'] as $stock)
        <option value="{{$stock->stock_id}}" @if($warehouseData->warehouse_inventory['warehouse_stock_id'] == $stock->stock_id) selected  @endif class="uk-input">
            {{$stock->stock_merchandise['stock_name']}}
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
                        <option value="{{$key_setting_stock_case_size}}" class="uk-input" @if($warehouseData->warehouse_inventory['warehouse_stock_id'] == $key_setting_stock_case_size) selected  @endif>
                            {{$item_setting_stock_case_size['description']}}
                        </option>
                        @endforeach
                    </select>
                </div>
            @else
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper($keyStock) }}</label>
                <input class="uk-input" type="number" name="form[warehouse][{{$keyStock}}]" value="{{$warehouseData->warehouse_inventory[$keyStock]}}">
            </div>
        @endif
    @endforeach
@endisset
</form>