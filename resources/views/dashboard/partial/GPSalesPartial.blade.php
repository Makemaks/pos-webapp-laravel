@php

use App\Models\Stock;
$totalPrice = 0;
$price = 0;
$orderList = $data['orderList']->groupBy('stock_id');


if (count($orderList) > 0) {
    
    $arrayGPList = Stock::StockGrossProfit( $orderList, $data );

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


<h3 class="uk-card-title">GP SALES</h3>
<div class="uk-overflow-auto uk-height-large">
        

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">

       
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
