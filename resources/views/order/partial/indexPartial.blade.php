@php
     use App\Models\Order;
     use App\Models\Stock;
     use App\Models\Receipt;
@endphp

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script> 
@endpush

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>Number</th>
            <th>Type</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
      
        @foreach ($data['orderList'] as $order)
            @php
                $orderList = Order::Receipt('order_id', $order->order_id)
                ->get();

                $orderTotal = Stock::OrderTotal($orderList);
            @endphp
            <tr>
                <td><a href="{{route('order.edit', $order->order_id)}}" class="uk-button uk-button-text">{{$order->order_id}}</a></td>
                <td>{{Order::OrderType()[$order->order_type]}}</td>
                @if ($order->payment_type)
                    <td>{{$order->payment_type}}</td>
                @endif
                <td>
                    <select class="uk-select" id="select-{{$order->order_id}}" onchange="OrderStatus(this, {{$order->order_id}})">
                        @foreach (Order::OrderStatus() as $status)
                            <option value="{{$loop->iteration}}" @if($order->order_status == $loop->iteration) selected = 'selected' @endif>{{$status}}</option>
                        @endforeach
                    </select>
                
                </td>
                <td>{{  $orderTotal }}</td>
                <td>{{$order->created_at}}</td>
                <td>
                 
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@include('partial.paginationPartial', ['paginator' => $data['orderList']])