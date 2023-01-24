@php

$table = 'fixedTotalPartial';
$totalPrice = 0;
$price = 0;
$totalCash = 0;
$totalCredit = 0;

$totalPrice = App\Models\Stock::OrderTotal($data['orderList']);

$expenseTotal = $totalPrice - $data['expenseList']->sum('expense_amount');

for ($i = 1; $i < count($data['settingModel']->setting_pos); $i++) {
    $totalCashQuantity = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['quantity'];
    $totalCashAmount = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['amount'];

    $totalCreditQuantity = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['quantity'];
    $totalCreditAmount = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['amount'];
}
$totaliser = [
    'NET sales' => ['Quantity' => $data['orderList']->count(), 'Total' => App\Helpers\MathHelper::FloatRoundUp($expenseTotal, 2)],
    'GROSS Sales' => ['Quantity' => $data['orderList']->count(), 'Total' => App\Helpers\MathHelper::FloatRoundUp($totalPrice, 2)],
    'CASH in Drawer' => ['Quantity' => $totalCashQuantity, 'Total' => App\Helpers\MathHelper::FloatRoundUp($totalCashAmount, 2)],
    'CREDIT in Drawer' => ['Quantity' => $totalCreditQuantity, 'Total' => App\Helpers\MathHelper::FloatRoundUp($totalCreditAmount, 2)],
    'TOTAL in Drawer' => ['Quantity' => $totalCashQuantity + $totalCreditQuantity, 'Total' => App\Helpers\MathHelper::FloatRoundUp($totalCashAmount + $totalCreditAmount, 2)],
    'Discount Total' => ['Quantity' => '', 'Total' => ''],
    'Covers' => ['Quantity' => '', 'Total' => ''],
    'GT Net' => ['Quantity' => '', 'Total' => ''],
    'GT All +ve' => ['Quantity' => '', 'Total' => ''],
    'CUST VERIFY1' => ['Quantity' => '', 'Total' => ''],
];

@endphp


<div>
    <h3 class="uk-card-title">WEB</h3>
    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
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


