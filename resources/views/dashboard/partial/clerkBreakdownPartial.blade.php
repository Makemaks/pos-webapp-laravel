@php


$totalCostPrice = 0;
$price = 0;

$clerkBreakdown = $data['clerkBreakdown'];
$clerkBreakdown = $clerkBreakdown->groupBy('user_id');

if (count($clerkBreakdown) > 0) {
    foreach ($clerkBreakdown as $receiptList) {
        $person = $receiptList[0]->person_name;
        $personName = json_decode($person);
        $totalCostPrice = 0;
        $price = 0;

        foreach ($receiptList as $receipt) {
            if ($receipt->receipt_id) {
                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                $totalCostPrice = $totalCostPrice + $price;
            }
        }

        $arrayclerkBreakdown[] = [
            'Number' => $receipt->receipt_user_id,
            'Name' => $personName->person_firstname,
            'total' => App\Helpers\MathHelper::FloatRoundUp($totalCostPrice, 2),
        ];
    }
} else {
    $arrayclerkBreakdown[] = [
        'Number' => '',
        'Name' => '',
        'total' => '',
    ];
}
@endphp


<div>
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">CLERK BREAKDOWN</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arrayclerkBreakdown[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayclerkBreakdown as $keyarrayclerkBreakdown => $itemarrayclerkBreakdown)
                    <tr>
                        @foreach ($itemarrayclerkBreakdown as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
