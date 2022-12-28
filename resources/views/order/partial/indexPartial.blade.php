@php
    $route = Str::before(Request::route()->getName(), '.');
    use App\Helpers\MathHelper;
    use App\Models\Order;
    use App\Models\Stock;
    use App\Models\Receipt;
    use App\Models\User;
   
@endphp

@push('scripts')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush

<form action="{{route('order.update', 0)}}" method="POST">
    @csrf
    @method('PATCH')
    <button type="submit" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Save</button>
    <div class="" uk-height-viewport="offset-top: true; offset-bottom: 50px">
        <div @if($route != 'order') class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30" @endif>
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
                        @foreach ($data['orderList'] as $orderKey =>  $order)
                            @php
                                $orderList = Order::Receipt('order_id', $order->order_id)->get();
                                $orderTotal = Stock::OrderTotal($orderList);
                                $userPerson = User::Person('user_id', $order->receipt_user_id)->first();
                               
                            @endphp
                        <tr>
                            <td><a href="{{route('order.edit', $order->order_id)}}"
                                    class="uk-button uk-button-default uk-border-rounded">{{$order->order_id}}</a></td>
                            <td>{{Order::OrderType()[$order->order_type]}}</td>
                            
                            <td>
                                @if ($order->payment_type)
                                    {{$order->payment_type}}
                                @endif
                            </td>
                           
                            <td>
                                <select class="uk-select">
                                    @foreach (Order::OrderStatus() as $status)
                                        <option  value="{{$loop->index}}" @if($order->order_status == $loop->iteration) selected @endif>{{$status}}</option>
                                    @endforeach
                                </select>
                                <input type="text" value="{{$order->order_id}}" name="order[{{$orderKey}}][order_id]" hidden>
                            </td>
                            <td>{{ MathHelper::FloatRoundUp($orderTotal, 2) }}</td>
                            <td>{{$order->store_name}}</td>
                            <td>{{$data['settingModel']->setting_pos[1]['name']}}</td>
                            <td>{{ json_decode($userPerson->person_name, true)['person_firstname'] }}</td>
                            <td>{{$order->created_at}}</td>
                            <td>
                                
                                <a href="{{route('order.index', ['order_id'=>$order->order_id, 'view' =>'availaibility'])}}"
                                    class="uk-button uk-button-default uk-border-rounded">Explore</a>
                            </td>
                        </tr>
                        @endforeach
                </tbody>
            </table>
        </div>
        <div class="uk-margin-large">
            @isset($data['orderList'])
                @include('partial.paginationPartial', ['paginator' => $data['orderList']])
            @endisset
        </div>
    </div>
</form>

