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
            <th>created_at</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    <tbody>
       
        @foreach ($data['warehouseList']->paginate(20) as $key => $warehouse)
            <tr>
                <td><input class="uk-checkbox" type="checkbox" name="warehouse[{{$key}}][checked_row]"></td>
                <input class="uk-checkbox" type="hidden" name="warehouse[{{$key}}][warehouse_id]" value="{{$warehouse->warehouse_id}}">
                <td><a href="{{route('warehouse.edit', $warehouse->warehouse_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_id}}</a></td>
                <td class="uk-text-truncate">{{$warehouse->warehouse_note}}</td>
                <td>{{ $warehouse->warehouse_reference }}</td>
                <td><a href="{{route('store.edit', $warehouse->warehouse_store_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_store_id}}</a></td>
                <td>
                    @php
                        $storeModel = Store::Stock()->first();
                    @endphp
                    <a href="{{route('store.edit', $warehouse->warehouse_store_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_store_id}}</a>
                </td>
                <td><a href="{{route('stock.edit', $warehouse->warehouse_stock_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_stock_id}}</a></td>
                <td><a href="{{route('stock.edit', $warehouse->warehouse_user_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_user_id}}</a></td>
                <td>{{ $warehouse->warehouse_cost_override }}</td>
                <td>{{ $warehouse->warehouse_quantity }}</td>
                <td>{{Str::upper(Warehouse::WarehouseStatus()[$warehouse->warehouse_status])}}</td>
                <td>{{Str::upper(Warehouse::WarehouseType()[$warehouse->warehouse_type])}}</td>
                <td>{{Str::upper(Warehouse::WarehouseCostType()[$warehouse->warehouse_cost_type])}}</td>
                <td>{{$warehouse->created_at}}</td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
    <div id="appendDelete" style="display: none"></div>
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn" style="display: none">Save</button>
</table>
</form>

<script>
    $(document).on('click', '.delete-btn', function () {
        $('#appendDelete').append("<input type='text' name='is_delete_request' value='true'>");
        // alert('sdfs');
        $('.save-btn').click();
    });
    $(document).on('click', '.reserve-checkbox', function () {
        $(':checkbox').each(function () {
            this.checked = !this.checked;
        });
    });
</script>







