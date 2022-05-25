@php
$table = 'eatInEatOutPartial';
$totalCostPrice = 0;
$price = 0;

$orderList = $data['eat_in_eat_out']->groupBy(function ($item) {
    return $item->created_at->format('d-m-Y');
});

if (count($orderList) > 0) {
    // by dates
    foreach ($orderList as $key => $receiptList) {
        $receiptList = $receiptList->groupBy('order_type');

        // by order_type
        foreach ($receiptList as $type => $value) {
            if ($type == 0) {
                $arrayeatInEatOut[] = [
                    'Date' => $key,
                    'Name' => 'Eat In',
                    'Quantity' => $receiptList[0]->count(),
                ];
            } else {
                $arrayeatInEatOut[] = [
                    'Date' => $key,
                    'Name' => 'Eat Out',
                    'Quantity' => $receiptList[1]->count(),
                ];
            }
        }
    }
} else {
    $arrayeatInEatOut[] = [
        'Date' => '',
        'Name' => '',
        'Quantity' => '',
    ];
}
@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
        <h3 class="uk-card-title">EAT IN EAT OUT</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arrayeatInEatOut[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayeatInEatOut as $keyarrayeatInEatOut => $itemarrayeatInEatOut)
                    <tr>
                        @foreach ($itemarrayeatInEatOut as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('document.button')
    </div>
</div>
