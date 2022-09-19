@extends('layout.master')
@php
    use App\Models\Warehouse;
@endphp
@section('content')
<form action="">
    <button type="submit">Save</button>
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th>Stock Name</th>
                <th>Order Quantity</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['orderList'] as $orderList)
            <tr>
                <td>{{json_decode($orderList->stock_merchandise)->stock_name}}</td>
                <td>{{$orderList->receipt_quantity}}</td>
                    <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>REF</th>
                                <th>Quantity</th>
                                <th>Adjust</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $warehouseList = Warehouse::Available($orderList->stock_id)
                            @endphp
                            @foreach($warehouseList as $warehouse)
                            <tr>
                                <td>{{$warehouse->warehouse_id}}</td>
                                <td>{{$warehouse->warehouse_quantity}}</td>
                                <td><input type="number" value="{{$orderList->receipt_quantity}}"><input type="text" hidden value="{{$warehouse->warehouse_id}}"></td>
                                <td> <a href="{{route('warehouse.index',['warehouse_id'=>$warehouse->warehouse_id,'action'=>'use','receipt_quantity'=>$orderList->receipt_quantity])}}">use</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            </tr>
            @endforeach
        </tbody>
    </table> 
</form>

@endsection
