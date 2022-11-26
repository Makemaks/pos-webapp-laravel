@php
    use App\Models\Warehouse;
    use App\Models\Store;
@endphp
<button class="uk-button uk-button-default uk-border-rounded uk-button-primary top-save-btn">Save</button>
<a class="uk-button uk-button-danger uk-border-rounded delete-btn">Delete</a>
<form action="{{route('warehouse.store')}}" method="post">
    @csrf
<table class="uk-table uk-table-small uk-table-divider">
  
    <thead>
        <tr>
            <th><input class="uk-checkbox reserve-checkbox" type="checkbox"></th>
            <th>REF</th>
            <th>note</th>
            <th>reference</th>
            <th>In</th>
            <th>Out</th>
            <th>stock_id</th>
            <th>user_id</th>
            <th>cost_override</th>
            <th>quantity</th>
            <th>status</th>
            <th>type</th>
            <th>cost</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['warehouseList']->latest()->paginate(20) as $key => $warehouse)
            <tr>
                <td><input class="uk-checkbox" type="checkbox" name="warehouse[{{$key}}][checked_row]"></td>
                <input class="uk-checkbox" type="hidden" name="warehouse[{{$key}}][warehouse_id]" value="{{$warehouse->warehouse_id}}">
                
                <td><a href="{{route('warehouse.edit', $warehouse->warehouse_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_id}}</a></td>
                <td><input class="uk-input" type="text" name="warehouse[{{$key}}][warehouse_note]" value="{{$warehouse->warehouse_note}}"></td>
                <td><input class="uk-input" type="text" name="warehouse[{{$key}}][warehouse_reference]" value="{{$warehouse->warehouse_reference}}"></td>
                <td><a href="{{route('store.edit', $warehouse->warehouse_store_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_store_id}}</a></td>
                <td>
                    @php
                        $storeModel = Store::Stock()->first();
                    @endphp
                    <a href="{{route('store.edit', $warehouse->warehouse_store_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_store_id}}</a>
                </td>
                <td><a href="{{route('stock.edit', $warehouse->warehouse_stock_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_stock_id}}</a></td>
                <td><a href="{{route('stock.edit', $warehouse->warehouse_user_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_user_id}}</a></td>
                <td><input class="uk-input" type="text" name="warehouse[{{$key}}][warehouse_cost_override]" value="{{$warehouse->warehouse_cost_override}}"></td>
                <td><input class="uk-input" type="text" name="warehouse[{{$key}}][warehouse_quantity]" value="{{$warehouse->warehouse_quantity}}"></td>
                <td>
                    <select class="uk-form-select" name="warehouse[{{$key}}][warehouse_status]">
                        @foreach(Warehouse::WarehouseStatus() as $warehouseStatusKey => $warehouseStatus)
                            <option value="{{$warehouseStatusKey}}" @if($warehouseStatusKey == $warehouse->warehouse_status) selected @endif>{{Str::upper($warehouseStatus)}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="uk-form-select" name="warehouse[{{$key}}][warehouse_type]">
                        @foreach(Warehouse::WarehouseType() as $warehouseTypeKey => $warehouseType)
                            <option value="{{$warehouseTypeKey}}" @if($warehouseTypeKey == $warehouse->warehouse_type) selected @endif>{{Str::upper($warehouseType)}}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <select class="uk-form-select" name="warehouse[{{$key}}][warehouse_cost_type]">
                        @foreach(Warehouse::WarehouseCostType() as $warehouseCostTypeKey => $warehouseCostType)
                            <option value="{{$warehouseCostTypeKey}}" @if($warehouseCostTypeKey == $warehouse->warehouse_cost_type) selected @endif>{{Str::upper($warehouseCostType)}}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        @endforeach
    </tbody>
    <input class="uk-checkbox" type="hidden" name="store_from_index">
    <div id="appendDelete" style="display: none"></div>
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn" style="display: none">Save</button>
</table>
</form>

<script>
    $(document).on('click', '.delete-btn', function () {
        $('#appendDelete').append("<input type='text' name='is_delete_request' value='true'>");
        $('.save-btn').click();
    });
    $(document).on('click', '.reserve-checkbox', function () {
        $(':checkbox').each(function () {
            this.checked = !this.checked;
        });
    });
    $(document).on('click','.top-save-btn', function() {
        $('.save-btn').click();
    });
</script>







