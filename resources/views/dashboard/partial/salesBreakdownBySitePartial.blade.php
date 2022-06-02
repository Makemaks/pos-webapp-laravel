@php
$table = 'salesBreakdownBySitePartial';

$totalCostPrice = 0;
$price = 0;

$orderList = $data['orderList'];
$orderList = $orderList->groupBy('store_id');

if (count($orderList) > 0) {
    foreach ($orderList as $receiptList) {
        $totalCostPrice = 0;
        $price = 0;
        $i = 0;

        foreach ($receiptList as $receipt) {
            if ($receipt->receipt_id) {
                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                $totalCostPrice = $totalCostPrice + $price;

                $i++;
            }
        }

        $arraySiteBreakdown[] = [
            'Number' => $receipt->store_id,
            'Site' => $receipt->store_name,
            'Sales' => $receiptList->count(),
            'Total' => App\Helpers\MathHelper::FloatRoundUp($totalCostPrice, 2),
        ];
    }
} else {
    $arraySiteBreakdown[] = [
        'Number' => '',
        'Site' => '',
        'Sales' => '',
        'Total' => '',
    ];
}

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">SALES BREAKDOWN BY SITE</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arraySiteBreakdown[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arraySiteBreakdown as $keyarraySiteBreakdown => $itemarraySiteBreakdown)
                    <tr>
                        @foreach ($itemarraySiteBreakdown as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        

    </div>
</div>
