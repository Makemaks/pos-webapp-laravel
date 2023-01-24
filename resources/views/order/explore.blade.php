@extends('layout.master')
@php
    use App\Models\Warehouse;
    use App\Models\Receipt;
@endphp
@section('content')
<form action="{{route('order.update', $data['orderList']->first()->order_id)}}" method="post">
    @method('PATCH')
    @csrf
    <button type="submit" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Save</button>
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th>REF</th>
                <th>Stock</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Warehouse</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['orderList'] as $orderList)
                <td> 
                    <button class="uk-button uk-button-default uk-border-rounded">
                        {{$orderList->receipt_id}}
                    </button>
                    <input type="text" name="receipt_id[]" value="{{$orderList->receipt_id}}" hidden>
                </td>
                <td>{{json_decode($orderList->stock_merchandise)->stock_name}}</td>
                <td>{{$orderList->receipt_stock_quantity}}</td>
                <td>
                    @if ($orderList->receipt_status)
                        {{Receipt::ReceiptStatus()[$orderList->receipt_status]}}
                    @endif
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
                                   
                                    <td>
                                        <button class="uk-button uk-button-default uk-border-rounded">
                                            {{$warehouse->warehouse_id}}
                                        </button>
                                    </td>
                                    <td>{{$warehouse->store_name}}</td>
                                    <td>{{$warehouse->warehouse_quantity}}</td>
                                    <td>{{Warehouse::WarehouseType()[$warehouse->warehouse_type]}}</td>
                                    <td>
                                        <input type="number" class="uk-input"  max="{{$orderList->warehouse_quantity}}"  min="0" name="receipt_stock_quantity[]" value="{{$orderList->receipt_stock_quantity}}">
                                    </td>
                                    <td> 
                                        <input name="warehouse_id[]" class="uk-checkbox" value="{{$warehouse->warehouse_id}}" type="checkbox" @if($warehouse->warehouse_store_id == $data['userModel']->store_id) checked @endif>
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
