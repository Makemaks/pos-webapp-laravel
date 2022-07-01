
@php
    use App\Models\Warehouse;
    use App\Models\Store;
  
@endphp

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>REF</th>
            <th>note</th>
            <th>reference</th>
            <th>In</th>
            <th>Out</th>
            <th>stock_id</th>
            <th>user_id</th>
            <th>price_override</th>
            <th>quantity</th>
            <th>status</th>
            <th>type</th>
            
            <th></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>

        @foreach ($data['warehouseList'] as $key => $warehouse)
        
            <tr>
                
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
                <td>{{ $warehouse->warehouse_price_override }}</td>
                <td>{{ $warehouse->warehouse_quantity }}</td>
                <td>{{Str::upper(Warehouse::WarehouseStatus()[$warehouse->warehouse_status])}}</td>
                <td>{{Str::upper(Warehouse::WarehouseType()[$warehouse->warehouse_type])}}</td>
             
            </tr>

        @endforeach
      
    </tbody>
</table>




