@php

use App\Models\Stock;
$orderList = $data['orderListASC'];
$orderList = $orderList->groupBy('order_id');

if (count($orderList) > 0) {
    foreach ($orderList as $receiptList) {
        $totalPrice = 0;
        $price = 0;
        $current_created_at = App\Models\Order::find($receiptList->first()->order_id)->created_at;

        $totalPrice = Receipt::ReceiptCartInitialize($receiptList);

        $array100Sale[] = [
            'time' => $current_created_at,
            'order_id' => $receiptList->first()->order_id,
            'total' => App\Helpers\MathHelper::FloatRoundUp($totalPrice, 2),
        ];
    }
} else {
    $array100Sale[] = [
        'time' => '',
        'order_id' => '',
        'total' => '',
    ];
}
@endphp
<div>
    <h3 class="uk-card-title">LAST 100 SALES</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($array100Sale[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($array100Sale as $keyArray100Sale => $itemArray100Sale)
                    <tr>
                        @foreach ($itemArray100Sale as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
