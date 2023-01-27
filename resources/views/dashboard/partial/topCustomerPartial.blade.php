@php
use App\Models\Receipt;

$table = 'topCustomerPartial';

$arraycustomerTop = [];

foreach ($data['orderList']->groupBy('order_account_id') as $orderList) {
      
      $data = Receipt::ReceiptCartInitialize( $orderList, $data);

      $arraycustomerTop[] = [
            'Account Num' => $orderList->first()->order_account_id,
            'Name' => $orderList->first()->account_name,
            'total' => $data['setupList']['order_price_total'],
      ];
}

$arraycustomerTop = collect($arraycustomerTop)->sortBy('total')->toArray();

@endphp


<h3 class="uk-card-title">TOP CUSTOMERS</h3>
<div class="uk-overflow-auto uk-height-large">
    
        @if (count($arraycustomerTop) > 0)
            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                <thead>
                    <tr>
                        @foreach ($arraycustomerTop[0] as $key => $item)
                            <th>{{ $key }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arraycustomerTop as $keyarraycustomerTop => $itemarraycustomerTop)
                        <tr>
                            @foreach ($itemarraycustomerTop as $key => $item)
                                <td>{{ $item }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
        

</div>
