@php

use App\Models\Receipt;


@endphp


<h3 class="uk-card-title">CLERK BREAKDOWN</h3>
<div class="uk-overflow-auto uk-height-large">

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-overflow-auto uk-height-large">
            <thead>
                <tr>
                  {{--   @foreach ($arrayclerkBreakdown[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($data['orderList']->groupBy('order_user_id') as $orderList)
                    @php
                         $data = Receipt::ReceiptCartInitialize( $orderList, $data);
                    @endphp
                    <tr>
                       
                        <td>{{ json_decode($orderList->first()->person_name, true)['person_firstname'] }}</td>
                        <td>{{ $orderList->count() }}</td>
                        <td>{{ $data['setupList']['order_price_total'] }}</td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
