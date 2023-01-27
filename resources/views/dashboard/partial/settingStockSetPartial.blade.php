@php
    use App\Models\Stock;
    use App\Models\Setting;
    use App\Models\Receipt;

    $settingModelStockSet = collect($data['settingModel']->setting_stock_set)->where('type', $type);
    
    
        foreach ( $settingModelStockSet as $stock_set_key => $stock_set_value) {

            foreach ($data['orderList']->groupBy('order_id') as $orderList) {

                foreach ($orderList as $orderKey => $order) {

                    if (in_array($stock_set_key, json_decode($order->stock_set, true) ) == false) {
                        $orderList->forget($orderKey);
                    }

                }

                $data = Receipt::ReceiptCartInitialize( collect($orderList->values()), $data);

                $setting_stock_set[] = [
                    'name' => $stock_set_value['name'],
                    'Quantity' => $orderList->count(),
                    'Total' => $data['setupList']['order_price_total'],
                ];

            }

            
                
        }

@endphp


<h3 class="uk-card-title">{{Str::upper(Setting::SettingStockSet()[$type])}} TOTAL</h3>
<div class="uk-overflow-auto uk-height-large">
    
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    <th>{{Str::upper(Setting::SettingStockSet()[$type])}}</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @isset($setting_stock_set)
                    @foreach ($setting_stock_set as $key => $item)
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['Quantity'] }}</td>
                            <td>{{ $item['Total'] }}</td>
                        </tr>
                    @endforeach
                @endisset
                
            </tbody>
        </table>
</div>
