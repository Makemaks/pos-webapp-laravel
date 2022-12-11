@php
$title = $data['title'];
$table = $data['table'];
$settingModel = $data['settingModel'];
$settingModel = $settingModel->setting_stock_group;
$quantity = 0;
$totalCostPrice = 0;
// dd($data['settingModel']);
$array = [];
foreach ($settingModel as $key => $value) {
    if ($value['type'] == 1) {
        foreach ($data['orderList']->sortBy('order_created_at') as $orderList) {
            $stock_merchandise = json_decode($orderList->stock_merchandise, true);
            if ($stock_merchandise) {
                if ($stock_merchandise['category_id'] == $key) {
                    $day = Carbon\Carbon::parse($orderList->order_created_at)->format('l');
                    $price = json_decode($orderList->stock_cost, true)[$stock_merchandise['category_id']][1]['price'];
                    // dd($price);
                    $totalCostPrice += $price;
                    $quantity++;

                    if (array_key_exists($day, $array)) {
                        $array[$day] = [
                            'Day' => $day,
                            'Quantity' => $array[$day]['Quantity'] + 1,
                            'Value' => App\Helpers\MathHelper::FloatRoundUp($array[$day]['Value'] + $price, 2),
                            'Avg Sale Value' => App\Helpers\MathHelper::FloatRoundUp($array[$day]['Value'] / $array[$day]['Quantity'], 2),
                            'Covers' => $array[$day]['Quantity'] + 1,
                            'Avg Covers' => App\Helpers\MathHelper::FloatRoundUp($array[$day]['Value'] / $array[$day]['Quantity'], 2),
                        ];
                    } else {
                        $array[$day] = [
                            'Day' => $day,
                            'Quantity' => 1,
                            'Value' => $price,
                            'Avg Sale Value' => $price / 1,
                            'Covers' => 1,
                            'Avg Covers' => $price / 1,
                        ];
                    }
                }
            }
        }
    }
}

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
                            <td></td>
                            <td>{{ $quantity }}</td>
                            <td>{{ App\Helpers\MathHelper::FloatRoundUp($totalCostPrice, 2) }}</td>
                            <td>{{ App\Helpers\MathHelper::FloatRoundUp($totalCostPrice / $quantity, 2) }}</td>
                            <td>{{ $quantity }}</td>
                            <td>{{ App\Helpers\MathHelper::FloatRoundUp($totalCostPrice / $quantity, 2) }}</td>
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
