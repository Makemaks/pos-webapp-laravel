@php
$title = $data['title'];
$table = $data['table'];
$settingModel = $data['settingModel'];
$settingModel = $settingModel->setting_stock_set_category_plu;
$currentDay = '';

// array for avg total per day TOTAL
$daily = [
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0,
    'Saturday' => 0,
    'Sunday' => 0,
];

// array for avg total per day QUANTITY
$amountDaily = [
    'Monday' => 0,
    'Tuesday' => 0,
    'Wednesday' => 0,
    'Thursday' => 0,
    'Friday' => 0,
    'Saturday' => 0,
    'Sunday' => 0,
];

foreach ($settingModel as $key => $value) {
    if ($key == 1) {
        // Loop 24 hours
        for ($i = 0; $i < 24; $i++) {
            // Variable reset for each period
            $price = 0;
            $totalPrice = 0;
            $monday = 0;
            $tuesday = 0;
            $wednesday = 0;
            $thursday = 0;
            $friday = 0;
            $saturday = 0;
            $sunday = 0;

            foreach ($data['orderList'] as $orderList) {
                $date = Carbon\Carbon::parse($orderList->order_created_at);
                $currentDay = $date->format('l');
                $hour = $date->format('H');

                // if hour of order is equal to period time (0-23)
                if ($hour == $i) {
                    $stock_merchandise = json_decode($orderList->stock_merchandise, true);

                    // get price
                    if ($orderList->receipt_id) {
                        $price = json_decode($orderList->stock_price, true)[$orderList->receipt_stock_price]['price'];

                        // creating variable for array
                        if ($currentDay === 'Monday') {
                            $monday = $price + $monday;
                        } elseif ($currentDay === 'Tuesday') {
                            $tuesday = $price + $tuesday;
                        } elseif ($currentDay === 'Wednesday') {
                            $wednesday = $price + $wednesday;
                        } elseif ($currentDay === 'Thursday') {
                            $thursday = $price + $thursday;
                        } elseif ($currentDay === 'Friday') {
                            $friday = $price + $friday;
                        } elseif ($currentDay === 'Saturday') {
                            $saturday = $price + $saturday;
                        } elseif ($currentDay === 'Sunday') {
                            $sunday = $price + $sunday;
                        }
                    }

                    // array
                    $arrayFirst[$i] = [
                        'Monday' => App\Helpers\MathHelper::FloatRoundUp($monday, 2),
                        'Tuesday' => App\Helpers\MathHelper::FloatRoundUp($tuesday, 2),
                        'Wednesday' => App\Helpers\MathHelper::FloatRoundUp($wednesday, 2),
                        'Thursday' => App\Helpers\MathHelper::FloatRoundUp($thursday, 2),
                        'Friday' => App\Helpers\MathHelper::FloatRoundUp($friday, 2),
                        'Saturday' => App\Helpers\MathHelper::FloatRoundUp($saturday, 2),
                        'Sunday' => App\Helpers\MathHelper::FloatRoundUp($sunday, 2),
                    ];
                }
            }
        }
    }
}

$tableHeader[] = ['Hour', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday', 'Hourly Average'];
@endphp

@if ($data['orderList']->count() > 0)
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    @include('document.button')
    <div class="uk-margin-top">
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    @foreach ($tableHeader[0] as $item)
                        <th>{{ $item }}</th>
                    @endforeach

                </tr>
            </thead>
            <tbody>
                {{-- 24 hours loop --}}
                @for ($no = 0; $no < 24; $no++)
                    @php
                        
                        // resetting variable every hour period
                        $hourly = 0;
                        $amount = 0;
                        $avg = 0;
                    @endphp
                    <tr>
                        <td>{{ $no }}</td>

                        {{-- checking if there's a data in that period --}}
                        @if (array_key_exists($no, $arrayFirst))
                            @foreach ($arrayFirst[$no] as $key => $value)
                                {{-- calculating avg hourly --}}
                                @php
                                    $daily[$key] = $daily[$key] + $value;
                                @endphp

                                {{-- display empty if no data --}}
                                @if ($value != 0)
                                    {{-- calculating avg daily and divider value --}}
                                    @php
                                        $hourly = $value + $hourly;
                                        $amount = 1 + $amount;
                                        $amountDaily[$key] = $amountDaily[$key] + 1;
                                    @endphp
                                    <td>{{ $value }}</td>
                                @else
                                    <td></td>
                                @endif

                                {{-- if last loop each period --}}
                                @if ($loop->last)
                                    @php
                                        $avg = $hourly / $amount;
                                    @endphp
                                    @if ($avg != 0)
                                        <td>{{ App\Helpers\MathHelper::FloatRoundUp($avg, 2) }}</td>
                                    @else
                                        <td>0</td>
                                    @endif
                                @endif
                            @endforeach
                        @else
                            {{-- empty td if no data in period --}}
                            @for ($i = 0; $i < 8; $i++)
                                @if ($i == 7)
                                    <td>0</td>
                                @else
                                    <td></td>
                                @endif
                            @endfor
                        @endif

                    </tr>

                    {{-- last loop in period, display avg daily --}}
                    @if ($no == 23)
                        <tr>
                            <td>Average a day</td>
                            @foreach ($daily as $key => $value)
                                @if ($value != 0)
                                    <td>{{ $value / $amountDaily[$key] }}</td>
                                @else
                                    <td>0</td>
                                @endif
                            @endforeach
                            <td></td>
                        </tr>
                    @endif
                @endfor
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
