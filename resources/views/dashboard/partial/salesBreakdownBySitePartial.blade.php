@php
use App\Models\Stock;

$totalPrice = 0;
$price = 0;

$orderList = $data['orderList'];
$orderList = $orderList->groupBy('store_id');

if (count($orderList) > 0) {
    foreach ($orderList as $receiptList) {
       
        $totalPrice = Receipt::ReceiptCartInitialize($receiptList);

        $arraySiteBreakdown[] = [
            'Number' => $receiptList->first()->store_id,
            'Site' => $receiptList->first()->store_name,
            'Sales' => $receiptList->first()->count(),
            'Total' => App\Helpers\MathHelper::FloatRoundUp($totalPrice, 2),
        ];
    }
} else {
    $arraySiteBreakdown[] = [
        'Number' => '',
        'Site' => '',
        'Sales' => '',
        'Total' => '',
    ];
}

@endphp

<h3 class="uk-card-title">SALES BREAKDOWN BY SITE</h3>
<div class="uk-overflow-auto uk-height-large">
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    @foreach ($arraySiteBreakdown[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arraySiteBreakdown as $keyarraySiteBreakdown => $itemarraySiteBreakdown)
                    <tr>
                        @foreach ($itemarraySiteBreakdown as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
