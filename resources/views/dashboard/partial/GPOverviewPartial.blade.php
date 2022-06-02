@php

$table = 'GPOverviewPartial';
$orderList = $data['orderList'];
$orderList = $orderList->groupBy('store_id');

if (count($orderList) > 0) {
    foreach ($orderList as $receiptList) {
        $totalCostPrice = 0;
        $price = 0;
        $totalStockProfit = 0;
        $totalactualPrice = 0;

        foreach ($receiptList as $receipt) {
            if ($receipt->receipt_id) {
                $defaultPrice = json_decode($receipt->stock_cost, true);
                $actualPrice = json_decode($receipt->stock_gross_profit, true);

                foreach ($defaultPrice as $key => $value) {
                    if ($value['default'] == 0) {
                        $totalStockProfit = $totalStockProfit + $value['price'];
                    }
                }

                $totalactualPrice = $totalactualPrice + $actualPrice['actual'];

                $quantity = $receiptList->count();
            }
        }

        // dd($totalStockProfit, $totalactualPrice, $quantity);

        $totalGP = $totalStockProfit - $totalactualPrice;

        $GPpercentage = ($totalGP / $quantity) * 100;

        $arrayGPOverview[] = [
            'GP %' => App\Helpers\MathHelper::FloatRoundUp($GPpercentage, 2) . '%',
            'Total GP' => App\Helpers\MathHelper::FloatRoundUp($totalGP, 2),
        ];
    }
} else {
    $arrayGPOverview[] = [
        'GP %' => '',
        'Total GP' => '',
    ];
}
@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">GP OVERVIEW</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arrayGPOverview[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayGPOverview as $keyarrayGPOverview => $itemarrayGPOverview)
                    <tr>
                        @foreach ($itemarrayGPOverview as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        
    </div>
</div>
