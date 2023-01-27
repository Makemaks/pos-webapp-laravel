@php
    use App\Models\Receipt;
    use App\Helpers\MathHelper;

    $table = 'fixedTotalPartial';
    $order_price_total = 0;
    $price = 0;
    $totalCash = 0;
    $totalCredit = 0;


    foreach ($data['orderList']->groupBy('order_id') as $orderList) {
      
        $data = Receipt::ReceiptCartInitialize( $orderList, $data);
        $order_price_total = $data['setupList']['order_price_total'];
    }


for ($i = 1; $i < count($data['settingModel']->setting_pos); $i++) {
    $totalCashQuantity = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['quantity'];
    $totalCashAmount = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['amount'];

    $totalCreditQuantity = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['quantity'];
    $totalCreditAmount = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['amount'];
}
$totaliser = [
    'NET sales' => ['Quantity' => $data['orderList']->count(), 'Total' => MathHelper::FloatRoundUp($data['setupList']['order_price_total'], 2)],
    'GROSS Sales' => ['Quantity' => $data['orderList']->count(), 'Total' => MathHelper::FloatRoundUp($data['setupList']['order_sub_total'], 2)],
    'CASH in Drawer' => ['Quantity' => $totalCashQuantity, 'Total' => MathHelper::FloatRoundUp($totalCashAmount, 2)],
    'CREDIT in Drawer' => ['Quantity' => $totalCreditQuantity, 'Total' => MathHelper::FloatRoundUp($totalCreditAmount, 2)],
    'TOTAL in Drawer' => ['Quantity' => $totalCashQuantity + $totalCreditQuantity, 'Total' => MathHelper::FloatRoundUp($totalCashAmount + $totalCreditAmount, 2)],
    'Discount Total' => ['Quantity' => count($data['setupList']['setting_offer']), 'Total' => $data['setupList']['stock_setting_offer_total']],
    'Covers' => ['Quantity' => '', 'Total' => ''],
    'GT Net' => ['Quantity' => '', 'Total' => ''],
    'GT All +ve' => ['Quantity' => '', 'Total' => ''],
    'CUST VERIFY1' => ['Quantity' => '', 'Total' => ''],
];

@endphp

<h3 class="uk-card-title">FIXED TOTAL</h3>
<div>
    
    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-overflow-auto uk-height-large">
        <thead>
            <tr>
                <th>Totaliser</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($totaliser as $key => $item)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $item['Quantity'] }}</td>
                    <td>{{ $item['Total'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


</div>


