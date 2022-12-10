@php
use App\Models\Stock;
$table = 'topCustomerPartial';
$totalPrice = 0;
$price = 0;

$customerTop = $data['customerTop'];
$customerTop = $customerTop->groupBy('company_store_id');

if (count($customerTop) > 0) {
    foreach ($customerTop as $receiptList) {
        $person = $receiptList[0]->person_name;
        $personName = json_decode($person);


        $totalPrice = Stock::OrderTotal($receiptList);

        $arraycustomerTop[] = [
            'Account Num' => $receiptList->first()->company_store_id,
            'Name' => $receiptList->first()->company_name,
            'total' => App\Helpers\MathHelper::FloatRoundUp($totalPrice, 2),
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
        

</div>
