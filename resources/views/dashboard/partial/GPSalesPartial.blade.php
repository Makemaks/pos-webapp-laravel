@php


$orderList = $data['orderList'];
$orderList = $orderList->groupBy('stock_id');

if (count($orderList) > 0) {
    foreach ($orderList as $receiptList) {
        $totalCostPrice = 0;
        $price = 0;
        $totalStockNet = 0;
        $totalactualPrice = 0;

        foreach ($receiptList as $receipt) {
            if ($receipt->receipt_id) {
                $defaultPrice = json_decode($receipt->stock_cost, true);
                $actualPrice = json_decode($receipt->stock_gross_profit, true);
                $stockNameJson = json_decode($receipt->stock_merchandise, true);
                $stockName = $stockNameJson['stock_name'];

                foreach ($defaultPrice as $key => $value) {
                    if ($value['default'] == 0) {
                        $totalStockNet = $totalStockNet + $value['price'];
                    }
                }

                $totalactualPrice = $totalactualPrice + $actualPrice['actual'];
                $quantity = $receiptList->count();
            }
        }

        $totalGP = $totalStockNet - $totalactualPrice;

        $GPpercentage = ($totalGP / $quantity) * 100;

        $arrayGPList[] = [
            'Number' => $receipt->stock_id,
            'Descriptor' => $stockName,
            'Profit' => App\Helpers\MathHelper::FloatRoundUp($totalGP, 2),
            'GP' => App\Helpers\MathHelper::FloatRoundUp($GPpercentage, 2) . '%',
        ];
    }

    $sortarraytopGPList = collect($arrayGPList)
        ->sortBy('Profit')
        ->reverse()
        ->toArray();

    $topGPList = array_slice($sortarraytopGPList, 0, 5);

    $sortarraybottomGPList = collect($arrayGPList)
        ->sortBy('Profit')
        ->toArray();

    $bottomGPList = array_slice($sortarraybottomGPList, 0, 5);

    $bottomGPListASC = collect($bottomGPList)
        ->sortBy('Profit')
        ->reverse()
        ->toArray();
} else {
    $arrayGPList[] = [
        'Number' => '',
        'Descriptor' => '',
        'Profit' => '',
        'GP' => '',
    ];
    $topGPList[] = [
        'Number' => '',
        'Descriptor' => '',
        'Profit' => '',
        'GP' => '',
    ];
    $bottomGPList[] = [
        'Number' => '',
        'Descriptor' => '',
        'Profit' => '',
        'GP' => '',
    ];
    $bottomGPListASC[] = [
        'Number' => '',
        'Descriptor' => '',
        'Profit' => '',
        'GP' => '',
    ];
}

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
        <h3 class="uk-card-title">GP SALES</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">

            <thead>
                <td>
                    <h5>Top GP %</h5>
                </td>
            </thead>
            <thead>
                <tr>
                    @foreach ($arrayGPList[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($topGPList as $keyarrayGPList => $itemarrayGPList)
                    <tr>
                        @foreach ($itemarrayGPList as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
              
                <tr> 
                    <td><h5>Bottom GP %</h5></td>
                </tr>

                @foreach ($bottomGPListASC as $keyarrayGPList => $itemarrayGPList)
                    <tr>
                        @foreach ($itemarrayGPList as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

        </table>
      
    </div>

</div>
