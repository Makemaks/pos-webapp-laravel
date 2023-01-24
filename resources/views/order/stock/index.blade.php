@extends('layout.master')
@php
    use App\Models\Warehouse;
    $count = 0;
@endphp
@section('content')



<form method="POST" id="orderForm" action="{{route('order.update', $data['orderList']->first()->first()->order_id)}}">
    @csrf
    @method('PATCH')
   
    <button submit="orderForm" type="submit" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Save</button>
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
                
                @foreach ($orderList as $order)
               
                    <tr>
                        <td>{{json_decode($order->stock_merchandise)->stock_name}}</td>
                        <td>{{$orderList->sum('receipt_stock_quantity')}}</td>
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
                                        $warehouseList = Warehouse::Available($order->stock_id);
                                        $checked = '';
                                        $available = false;
                                     
                                    @endphp

                                   
                                   
                                    @foreach($warehouseList as $key => $warehouse)
                                       

                                            <tr>
                                                <td>{{$warehouse->warehouse_id}}</td>
                                                <td>{{$warehouse->warehouse_quantity}}</td>
                                                <td>
                                                         
                                                   @if ($warehouse->warehouse_quantity > $orderList->sum('receipt_stock_quantity'))
                                                        <input type="number" class="uk-input"  max="{{$warehouse->warehouse_quantity}}"  min="0" name="receipt_stock_quantity[]" value="{{$orderList->sum('receipt_stock_quantity')}}">
                                                   @else
                                                        <input type="number" class="uk-input"  max="{{$warehouse->warehouse_quantity}}"  min="0" name="receipt_stock_quantity[]" value="{{$warehouse->warehouse_quantity}}">
                                                   @endif
                                                    
                                                </td>
                                                <td>
                                                    @php
                                                    
                                                        if ($warehouse->warehouse_quantity > $order->receipt_stock_quantity  && $checked != 'checked' && $available == false) {
                                                            $checked = 'checked';
                                                            $available = true;
                                                        }else{
                                                            $checked = '';
                                                        }
                                                        
                                                    
                                                    @endphp
                                                    
                                                    <input class="uk-checkbox" type="checkbox" {{$checked}} name="receipt_warehouse_id[{{$count}}]" value="{{$warehouse->warehouse_id}}">
                                               

                                                    @php
                                                        $count++;
                                                    @endphp
                                                </td>
                                            </tr>
                                       
                                    @endforeach
                                   
                                </tbody>
                            </table>
                        </td>
                            
                    </tr>
                    @break
                @endforeach
                    
            @endforeach
        </tbody>
    </table> 
</form>

@endsection
