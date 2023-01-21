@php

$table = 'finaliseKeyPartial';
$setting_model = $data['settingModel'];
$orderList = $data['orderList'];
$orderList = $orderList->groupBy('order_id');



foreach ($orderList as $key => $setting) {
    foreach ( json_decode($setting->first()->order_setting_key) as $order_setting_key ) {
       if ( $order_setting_key->value ) {
            $array[ $order_setting_key->setting_key_group ][] = [
                'name' => $order_setting_key,
                'quantity' => 0,
                'total' => 0,
            ];
       }
    }
}

// Group by Setting Key value
/* foreach ($setting_model->setting_key as $key => $setting) {
    if ($setting['value'] != null) {
        $array[$setting['value']] = [
            'name' => $setting['value'],
            'quantity' => 0,
            'total' => 0,
        ];
    }
} */

/* foreach ($orderList as $key => $order) {
    $order_finalise_key_value = json_decode($order->first()->order_finalise_key, true);

    if ($order_finalise_key_value) {
        foreach ($order_finalise_key_value as $key => $order_key) {
            foreach ($setting_model->setting_key as $settingKey => $value) {
                if (array_key_exists($value['setting_key_type'], $array) && $order_key['ref'] == $settingKey && $value['value'] != null) {
                    //

                    $array[$value['setting_key_type']]['total'] = $order_key['total'] + $array[$value['setting_key_type']]['total'];
                    $array[$value['setting_key_type']]['quantity'] = $array[$value['setting_key_type']]['quantity'] + 1;

                    $array[$value['value']]['quantity'] = $order_key['total'] / $value['value'] + $array[$value['value']]['quantity'];
                    $array[$value['value']]['total'] = $array[$value['value']]['total'] + $order_key['total'];

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
} */


@endphp

<div>
    <h3 class="uk-card-title">FINALISE KEY</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
           
            <thead>
                    <tr>
                        <th>Name</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($array)
                        @foreach ($array as $keyarray => $itemarray)
                            <tr>
                                <td>{{$keyarray}}</td>
                                <td>{{count($itemarray)}}</td>
                                <td>{{collect($itemarray)->flatten()->sum('value')}}</td>
                            </tr>
                        @endforeach
                    @endisset
                </tbody>
           
        </table>
</div>
