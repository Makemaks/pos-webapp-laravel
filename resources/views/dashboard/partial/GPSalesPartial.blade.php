@php

use App\Models\Stock;
$totalPrice = 0;
$price = 0;
$orderList = $data['orderList']->groupBy('stock_id');


if (count($orderList) > 0) {
    foreach ($orderList as $receiptList) {
    

        $totalPrice = Stock::OrderTotal($receiptList);

        $quantity = $receiptList->count();

        if (json_decode($receiptList->first()->stock_gross_profit)) {
            $rrptotalPrice = $quantity * json_decode($receiptList->first()->stock_gross_profit)->rrp;

            $totalGP = $rrptotalPrice - $totalPrice;

            $GPpercentage = ($totalGP / $quantity) * 100;

            $arrayGPList[] = [
                'Number' => $receiptList->first()->stock_id,
                'Descriptor' => json_decode($receiptList->first()->stock_merchandise)->stock_name,
                'Profit' => App\Helpers\MathHelper::FloatRoundUp($totalGP, 2),
                'GP' => App\Helpers\MathHelper::FloatRoundUp($GPpercentage, 2) . '%',
            ];
        }
       
    }

    $sortarraytopGPList = collect($arrayGPList)
        ->sortBy('Profit')
        ->reverse()
        ->toArray();

    $topGPList = array_slice($sortarraytopGPList, 0, 5);

    $sortarraybottomGPList = collect($arrayGPList)
        ->sortBy('Profit')
        ->toArray();

    $bottomGPList = array_slice($sortarraybottomGPList, 0, 5);

    $bottomGPListASC = collect($bottomGPList)
        ->sortBy('Profit')
        ->reverse()
        ->toArray();
} else {
    $arrayGPList[] = [
        'Number' => '',
        'Descriptor' => '',
        'Profit' => '',
        'GP' => '',
    ];
  
}

@endphp
<div>
        <h3 class="uk-card-title">GP SALES</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">

       
            <thead>
                <tr>
                    @foreach ($arrayGPList[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><h5>Top GP %</h5></td>
                </tr>
                @foreach ($arrayGPList as $keyarrayGPList => $itemarrayGPList)
                    <tr>
                        @foreach ($itemarrayGPList as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
              
                <tr> 
                    <td><h5>Bottom GP %</h5></td>
                </tr>

                @foreach ($arrayGPList as $keyarrayGPList => $itemarrayGPList)
                    <tr>
                        @foreach ($itemarrayGPList as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>

        </table>
   
</div>
