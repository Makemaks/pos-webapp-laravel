@php
     use App\Helpers\MathHelper;
     use App\Models\Order;
     use App\Models\Stock;
     use App\Models\Receipt;
     use App\Models\User;
@endphp

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script> 
@endpush

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>Ref</th>
            <th>Type</th>
            <th>Status</th>
            <th>Amount</th>
            <th>Site</th>
            <th>Pos</th>
            <th>User</th>
            <th>Date</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
      
        @foreach ($data['orderList'] as $order)
            
            @php
                $orderList = Order::Receipt('order_id', $order->order_id)->get();
                $orderTotal = Stock::OrderTotal($orderList);
            
                $userPerson = User::Person('user_id', $orderList->last()->receipt_user_id)->first();

            @endphp

            <tr>
                <td><a href="{{route('order.edit', $order->order_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$order->order_id}}</a></td>
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
                <td>{{ MathHelper::FloatRoundUp($orderTotal, 2) }}</td>
                <td>{{$order->store_name}}</td>
                <td>{{$data['settingModel']->setting_pos[1]['name']}}</td>
                <td>{{ json_decode($userPerson->person_name, true)['person_firstname'] }}</td>
                <td>{{$order->created_at}}</td>
                <td>
                
                </td>
            </tr>
            
        @endforeach

    </tbody>
</table>
@include('partial.paginationPartial', ['paginator' => $data['orderList']])