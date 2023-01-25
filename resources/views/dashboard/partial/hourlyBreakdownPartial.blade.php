@php

$table = 'hourlyBreakdownPartial';
$totalPrice = 0;
$orderList = $data['orderHourly'];
$orderList = $orderList->groupBy('order_id');

if (count($orderList) > 0) {
    $count = 0;
    $orderArray = [];

    $averageSales = 0;
    $nowCarbon = Carbon\Carbon::now();

    $current_minute = $nowCarbon->setTime(0, 0, 0);

    $i = 0;

    for ($i = 0; $i < 96; $i++) {
        $count++;

        $totalPrice = 0;
        $averageSales = 0;
        $totalQuantity = 0;
        if ($i == 0) {
            $current_minute = Carbon\Carbon::now()->setTime(0, 0, 0);
            $price_each_order = 0;
            $quantity_each_order = 0;
            $averageSales = 0;
        } else {
            $current_minute = $current_minute->copy()->addMinutes(15);
            $previous_minute = $current_minute->copy()->subMinutes(15);

            foreach ($orderList as $key => $receiptList) {
                $current_order_minute = App\Models\Order::find($receiptList->first()->order_id)->created_at->format('H:i');

                $current_order_minute_carbon = Carbon\Carbon::parse($current_order_minute);

                if ($current_order_minute_carbon->gte($previous_minute) && $current_order_minute_carbon->lt($current_minute)) {
                    $price_each_order = App\Models\Receipt::ReceiptCartInitialize($receiptList);
                    $quantity_each_order = $receiptList->count();
                    $totalQuantity = $totalQuantity + $quantity_each_order;
                    $totalPrice = $totalPrice + $price_each_order;
                } else {
                    $price_each_order = 0;
                    $quantity_each_order = 0;
                    $averageSales = 0;

                    $totalQuantity = $totalQuantity + $quantity_each_order;
                    $totalPrice = $totalPrice + $price_each_order;
                }

                if ($totalQuantity != 0) {
                    $averageSales = $totalPrice / $totalQuantity;
                } else {
                    $averageSales = 0;
                }
            }
        }

        $orderArrayTable[$i] = [
            'Hour' => $current_minute->format('H:i'),
            'Total' => App\Helpers\MathHelper::FloatRoundUp($totalPrice, 2),
            'Sales' => $totalQuantity,
            'Average Sales' => App\Helpers\MathHelper::FloatRoundUp($averageSales, 2),
        ];
    }
} else {
    $orderArrayTable[1] = [
        'Hour' => '',
        'Total' => '',
        'Sales' => '',
        'Average Sales' => '',
    ];
}
@endphp
<div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
    <h3 class="uk-card-title">HOURLY BREAKDOWN</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($orderArrayTable[1] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($orderArrayTable as $keyorderArrayTable => $itemorderArrayTable)
                    <tr>
                        @foreach ($itemorderArrayTable as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
