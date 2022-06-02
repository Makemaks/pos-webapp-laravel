@php

$table = 'specialsManagerPartial';
$orderList = $data['orderSettingList'];

$orderList = $orderList->groupBy('stock_id');

if (count($orderList) > 0) {
    foreach ($orderList as $stockId => $receiptList) {
        $totalCostPrice = 0;
        $price = 0;

        foreach ($receiptList as $key => $receipt) {
            if ($receipt->receipt_id) {
                // product name
                $stockNameJson = json_decode($receipt->stock_merchandise, true);
                $stockName = $stockNameJson['stock_name'];

                // category name
                $category_id = json_decode($receipt->stock_merchandise, true)['category_id'];
                $setting_stock_group = json_decode($receipt->setting_stock_group, true);
                $kpcat = $setting_stock_group[$category_id]['description'];

                // price 1 and 2
                $stock_cost = json_decode($receipt->stock_cost, true);
                $price_1 = $stock_cost[1]['price'];
                $price_2 = $stock_cost[2]['price'];
            }
        }

        $arraySpecialsManager[] = [
            'PLU' => $stockId,
            'NAME' => $stockName,
            'PRICE1L1' => App\Helpers\MathHelper::FloatRoundUp($price_1, 2),
            'PRICE2L2' => App\Helpers\MathHelper::FloatRoundUp($price_2, 2),
            'KPCAT' => $kpcat,
        ];
    }

    $arraySpecialsManager = collect($arraySpecialsManager)
        ->sortBy('PLU')
        ->toArray();
} else {
    $arraySpecialsManager[] = [
        'PLU' => '',
        'NAME' => '',
        'PRICE1L1' => '',
        'PRICE2L2' => '',
        'KPCAT' => '',
    ];

    // dd($arraySpecialsManager);
}
@endphp
<div>
    @if ($arraySpecialsManager[0]['PLU'] !== '')
        <div class="uk-card uk-card-default uk-card-body">
            <h3 class="uk-card-title">SPECIALS MANAGER</h3>

            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
                <thead>
                    <tr>
                        @foreach ($arraySpecialsManager[0] as $key => $item)
                            <th>{{ $key }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($arraySpecialsManager as $keyarraySpecialsManager => $itemarraySpecialsManager)
                        <tr>
                            @foreach ($itemarraySpecialsManager as $key => $item)
                                <td>{{ $item }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
        @else
            <div class="uk-card uk-card-default uk-card-body">
                <h3 class="uk-card-title">SPECIALS MANAGER</h3>
                <h6 style="">INSTRUCTIONS FOR USE</h6>
                <p style="font-size: 12px">The Specials Manager widget is designed to allow limited access users to
                    edit
                    nominated fields of PLU's within defined PLU Ranges at a site level. <br> <br> To configure this
                    widget
                    please select a site from the Site Selecter at the top of the page and then click the settings
                    link
                    in
                    the top right corner of this widget.</p>
    @endif
</div>
</div>
