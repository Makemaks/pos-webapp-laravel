@extends('layout.master')
@php
    use App\Models\Warehouse;
    use App\Models\Receipt;
@endphp
@section('content')
<form action="{{route('warehouse.store')}}" method="post">
    @csrf
    <button type="submit" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Save</button>
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th>Stock</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Warehouse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['orderList'] as $orderList)
            <tr>
                <td>{{json_decode($orderList->stock_merchandise)->stock_name}}</td>
                <td>{{$orderList->receipt_quantity}}</td>
                <td>
                    {{Receipt::ReceiptStatus()[$orderList->receipt_status]}}
                </td>
                <td>
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>REF</th>
                                <th>Store</th>
                                <th>Quantity</th>
                                <th>Type</th>
                                <th>Adjust</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $warehouseList = Warehouse::Available($orderList->stock_id)
                            @endphp
                            @foreach($warehouseList as $key => $warehouse)
                                <tr>
                                    <td>{{$warehouse->warehouse_id}}</td>
                                    <td>{{$warehouse->store_name}}</td>
                                    <td>{{$warehouse->warehouse_quantity}}</td>
                                    <td>{{Warehouse::WarehouseType()[$warehouse->warehouse_type]}}</td>
                                    <td><input type="number" class="uk-input"  max="{{$orderList->warehouse_quantity}}"  min="0" name="receipt_quantity[]" value="{{$orderList->receipt_quantity}}"><input type="text" name="warehouse_id[]" hidden value="{{$warehouse->warehouse_id}}"></td>
                                    <td> 
                                        <input name="receipt_available[]" class="uk-checkbox" value="{{$warehouse->warehouse_id}}" type="checkbox" @if($warehouse->warehouse_store_id == $data['userModel']->store_id) checked @endif>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </td>
                    
            </tr>
            @endforeach
        </tbody>
    </table> 
</form>

@endsection
