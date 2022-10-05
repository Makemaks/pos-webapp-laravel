@php
$title = $data['title'];
$table = $data['table'];

$dataModel = $data['orderListASC']->groupBy('order_id');
$totalCostPrice = 0;
$totalSales = 0;
$totalAvgSaleValue = 0;
$totalAvgItemsPerSale = 0;
$totalItems = 0;
$array = [];

foreach ($dataModel as $user_id => $value) {
    $sales = 0;
    foreach ($value as $key => $orderList) {
        if ($orderList->receipt_id) {
            $date = Carbon\Carbon::parse($orderList->order_created_at);
            $datePeriod_round_down = date('H', strtotime($date));
            $price = json_decode($orderList->stock_cost, true)[$orderList->receipt_stock_cost]['price'];
            $totalCostPrice = $totalCostPrice + $price;

            if (array_key_exists($datePeriod_round_down, $array)) {
                $array[$datePeriod_round_down] = [
                    'Period' => date('H:00', strtotime($date)) . '-' . date('H:59', strtotime($date)),
                    '($) Total' => App\Helpers\MathHelper::FloatRoundUp($price + $array[$datePeriod_round_down]['($) Total'], 2),
                    'Sales' => $sales++,
                    'Items' => App\Helpers\MathHelper::FloatRoundUp(1 + $array[$datePeriod_round_down]['Items'], 2),
                    'Avg Sale Value' => App\Helpers\MathHelper::FloatRoundUp($array[$datePeriod_round_down]['($) Total'] / $array[$datePeriod_round_down]['Items'], 2),
                    'Avg Items Per Sale' => '',
                    '(%) Total' => '',
                ];
            } else {
                $array[$datePeriod_round_down] = [
                    'Period' => date('H:00', strtotime($date)) . '-' . date('H:59', strtotime($date)),
                    '($) Total' => $price,
                    'Sales' => 1,
                    'Items' => 1,
                    'Avg Sale Value' => $price / 1,
                    'Avg Items Per Sale' => '',
                    '(%) Total' => '',
                ];
            }
        }
    }
}

foreach ($array as $key => $value) {
    $array[$key]['Avg Items Per Sale'] = App\Helpers\MathHelper::FloatRoundUp($value['Items'] / $value['Sales'], 0);
    $array[$key]['(%) Total'] = App\Helpers\MathHelper::FloatRoundUp(($value['($) Total'] / $totalCostPrice) * 100, 2);
    $totalSales = $totalSales + $value['Sales'];
}

foreach ($array as $key => $value) {
    $totalAvgSaleValue = $totalAvgSaleValue + $value['Avg Sale Value'];
    $totalAvgItemsPerSale = $totalAvgItemsPerSale + $value['Avg Items Per Sale'];
    $totalItems = $totalItems + $value['Items'];
}

$avgSaleValue = App\Helpers\MathHelper::FloatRoundUp($totalAvgSaleValue / count($array), 2);
$avgItemsPerSale = App\Helpers\MathHelper::FloatRoundUp($totalAvgItemsPerSale / count($array), 0);
$arrayTotal = [
    'Period' => 'Total',
    '($) Total' => App\Helpers\MathHelper::FloatRoundUp($totalCostPrice, 2),
    'Sales' => App\Helpers\MathHelper::FloatRoundUp($totalSales, 0),
    'Items' => App\Helpers\MathHelper::FloatRoundUp($totalItems, 0),
    'Avg Sale Value' => App\Helpers\MathHelper::FloatRoundUp($avgSaleValue, 2),
    'Avg Items Per Sale' => App\Helpers\MathHelper::FloatRoundUp($avgItemsPerSale, 0),
    '(%) Total' => 100,
];

ksort($array);
@endphp

@if ($array != null)
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    @include('document.button')
    <div class="uk-margin-top">
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    @foreach ($array[array_key_first($array)] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($array as $keyarray => $itemarray)
                    <tr>
                        @foreach ($itemarray as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>

                    @if ($loop->last)
                        <tr>
                            @foreach ($arrayTotal as $key => $item)
                                <td>{{ $item }}</td>
                            @endforeach
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    <div class="uk-alert-danger uk-border-rounded" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>No data to display.</p>
    </div>
@endif
