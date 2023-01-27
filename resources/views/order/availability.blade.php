@extends('layout.master')
@php
    use App\Models\Warehouse;
@endphp
@section('content')
<form action="{{route('warehouse.store')}}" method="post">
    @csrf
    <button type="submit" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Save</button>
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th>Stock Name</th>
                <th>Order Quantity</th>
                <th>WareHouse Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data['orderList'] as $orderList)
            <tr>
                <td>{{json_decode($orderList->stock_set)->stock_name}}</td>
                <td>{{$orderList->receipt_quantity}}</td>
                <td>
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
                            @foreach($warehouseList as $key => $warehouse)
                            <tr>
                                <td>{{$warehouse->warehouse_id}}</td>
                                <td>{{$warehouse->warehouse_quantity}}</td>
                                <td><input type="number" class="uk-input"  max="{{$orderList->warehouse_quantity}}"  min="0" name="receipt_quantity[]" value="{{$orderList->receipt_quantity}}"><input type="text" name="warehouse_id[]" hidden value="{{$warehouse->warehouse_id}}"></td>
                                <td> <a  class="uk-button uk-button-primary uk-border-rounded" href="{{route('warehouse.index',['warehouse_id'=>$warehouse->warehouse_id,'action'=>'use','receipt_quantity'=>$orderList->receipt_quantity])}}">Use</a></td>
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
