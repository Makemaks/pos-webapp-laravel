@php

$table = 'stockSearchPartial';
$stockList = $data['orderList'];
$stockList = $stockList->groupBy('stock_id');

if (count($stockList) > 0) {
    foreach ($stockList as $key => $receiptList) {
        foreach ($receiptList as $receipt) {
            if ($receipt->receipt_id) {
                $stockNameJson = json_decode($receipt->stock_merchandise, true);
                $stockName = $stockNameJson['stock_name'];

                $totalCostPrice = \App\Models\Stock::OrderTotal($receiptList);
                $quantity_each_stock = $receiptList->count();
            }
        }

        $arraystockSearch[] = [
            'Stock Name' => $stockName,
            'Sales' => $quantity_each_stock,
            'Total' => App\Helpers\MathHelper::FloatRoundUp($totalCostPrice, 2),
        ];
    }
} else {
    $arraystockSearch[] = [
        'Stock Name' => '',
        'Sales' => '',
        'Total' => '',
    ];
}

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
        <h3 class="uk-card-title">STOCK SEARCH</h3>


        <div class="uk-margin">
            <form class="uk-search uk-search-default">
                <a href="" class="uk-search-icon-flip" uk-search-icon></a>
                <input class="uk-search-input" type="search" placeholder="Search">
            </form>
        </div>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll scroll">
            <thead>
                <tr>
                    @foreach ($arraystockSearch[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arraystockSearch as $keyarraystockSearch => $itemarraystockSearch)
                    <tr>
                        @foreach ($itemarraystockSearch as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>

        @include('document.button')
    </div>
</div>
