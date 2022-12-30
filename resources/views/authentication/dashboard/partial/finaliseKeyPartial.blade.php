@php

$table = 'finaliseKeyPartial';
$setting_model = $data['settingModel'];
$orderList = $data['orderList'];
$orderList = $orderList->groupBy('order_id');

foreach ($setting_model->setting_key_type as $key => $setting) {
    $array[$key] = [
        'name' => $setting,
        'quantity' => 0,
        'total' => 0,
    ];
}

// Group by Setting Key value
foreach ($setting_model->setting_key as $key => $setting) {
    if ($setting['value'] != null) {
        $array[$setting['value'] . 'pound'] = [
            'name' => $setting['value'] . ' Pound',
            'quantity' => 0,
            'total' => 0,
        ];
    }
}

foreach ($orderList as $key => $order) {
    $order_setting_key_value = json_decode($order->first()->order_setting_key, true);

    if ($order_setting_key_value) {
        foreach ($order_setting_key_value as $key => $order_key) {
            foreach ($setting_model->setting_key as $settingKey => $value) {
                if (array_key_exists($value['setting_key_type'], $array) && $order_key['ref'] == $settingKey && $value['value'] != null) {
                    //

                    $array[$value['setting_key_type']]['total'] = $order_key['total'] + $array[$value['setting_key_type']]['total'];
                    $array[$value['setting_key_type']]['quantity'] = $array[$value['setting_key_type']]['quantity'] + 1;

                    $array[$value['value'] . 'pound']['quantity'] = $order_key['total'] / $value['value'] + $array[$value['value'] . 'pound']['quantity'];
                    $array[$value['value'] . 'pound']['total'] = $array[$value['value'] . 'pound']['total'] + $order_key['total'];

                    //
                } elseif (array_key_exists($value['setting_key_type'], $array) && $order_key['ref'] == $settingKey && $value['setting_key_type'] == 3) {
                    // IF ITS VOUCHER
                } elseif (array_key_exists($value['setting_key_type'], $array) && $order_key['ref'] == $settingKey && $value['value'] == null && $value['setting_key_type'] != 3) {
                    // IF ITS NON CASH
                    $array[$value['setting_key_type']]['total'] = $order_key['total'] + $array[$value['setting_key_type']]['total'];
                    $array[$value['setting_key_type']]['quantity'] = $array[$value['setting_key_type']]['quantity'] + 1;
                }
            }
        }
    }
}
@endphp

<div>
    <h3 class="uk-card-title">FINALISE KEY</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($array[1] as $key => $item)
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
                @endforeach
            </tbody>
        </table>
</div>
