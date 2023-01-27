@php

use App\Models\Receipt;


$array100Sale[] = [
    'time' => '',
    'order_id' => '',
    'total' => '',
];


@endphp


<h3 class="uk-card-title">LAST 100 SALES</h3>
<div class="uk-overflow-auto uk-height-large">
    
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    @foreach ($array100Sale[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($data['orderList']->groupBy('order_id')->sortBy('order_id') as $orderList)
                    @php
                         $data = Receipt::ReceiptCartInitialize( $orderList, $data);
                    @endphp
                    <tr>
                       
                        <td>{{ $orderList->first()->created_at }}</td>
                        <td>{{ $orderList->first()->order_id }}</td>
                        <td>{{ $data['setupList']['order_price_total'] }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
