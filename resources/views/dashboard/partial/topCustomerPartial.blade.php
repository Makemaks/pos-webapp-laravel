@php
$table = 'topCustomerPartial';
$totalCostPrice = 0;
$price = 0;

$customerTop = $data['customerTop'];
$customerTop = $customerTop->groupBy('company_store_id');

if (count($customerTop) > 0) {
    foreach ($customerTop as $receiptList) {
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

        $arraycustomerTop[] = [
            'Account Num' => $receipt->company_store_id,
            'Name' => $receipt->company_name,
            'total' => App\Helpers\MathHelper::FloatRoundUp($totalCostPrice, 2),
        ];
    }
} else {
    $arraycustomerTop[] = [
        'Account Num' => '',
        'Name' => '',
        'total' => '',
    ];
}

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
        <h3 class="uk-card-title">TOP CUSTOMERS</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arraycustomerTop[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arraycustomerTop as $keyarraycustomerTop => $itemarraycustomerTop)
                    <tr>
                        @foreach ($itemarraycustomerTop as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('document.button')
    </div>
</div>
