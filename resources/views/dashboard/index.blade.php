@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script> 
@endpush
@php
    use App\Helpers\MathHelper;
    use App\Models\Order;
    use App\Models\Receipt;
    use App\Models\User;
    use App\Models\Stock;
    use Carbon\Carbon;

@endphp

@section('content')   


    <div class="">
       
        <div>
            @include('dashboard.partial.datePeriodPartial')
        </div>


        {{-- first row --}}
        <div class="uk-margin uk-child-width-1-2@l" uk-grid uk-height-match>

            <div>
                
                @php
                        $totalCostPrice = 0;
                        $totalCash = 0;
                        $totalCredit = 0;
                    

                    
                        $totalCostPrice = Stock::OrderTotal($data['orderList']);

                        $expenseTotal = $totalCostPrice - $data['expenseList']->sum('expense_amount');
                    
                    

                        for ($i=1; $i < count($data['settingModel']->setting_pos); $i++) { 
                            $totalCashQuantity = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['quantity'];
                            $totalCashAmount = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['amount'];

                            $totalCreditQuantity = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['quantity'];
                            $totalCreditAmount = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['amount'];
                        }

                        $totaliser = [
                            'NET sales' => ['Quantity' => $data['orderList']->count(), 'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2)],
                            'GROSS Sales' => ['Quantity' => $data['expenseList']->count(), 'Total' => MathHelper::FloatRoundUp($expenseTotal, 2)],
                            'CASH in Drawer' => ['Quantity' => $totalCashQuantity, 'Total' =>  MathHelper::FloatRoundUp($totalCashAmount, 2)],
                            'CREDIT in Drawer' => ['Quantity' => $totalCreditQuantity, 'Total' =>  MathHelper::FloatRoundUp($totalCreditAmount, 2)],
                            'TOTAL in Drawer' => ['Quantity' => $totalCashQuantity+$totalCreditQuantity, 'Total' => MathHelper::FloatRoundUp($totalCashAmount + $totalCreditAmount, 2)],
                            'Discount Total' => ['Quantity' => '', 'Total' => ''],
                            'Covers' => ['Quantity' => '', 'Total' => ''],
                            'GT Net' => ['Quantity' => '', 'Total' => ''],
                            'GT All +ve' => ['Quantity' => '', 'Total' => ''],
                            'CUST VERIFY1' => ['Quantity' => '', 'Total' => ''],
                        ];

                @endphp

                <div class="">
                    <p class="uk-h4">FIXED TOTAL</p>
                </div>
               
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            <th>Totaliser</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($totaliser as $key => $item)
                            <tr>
                                <td>{{$key}}</td>
                                <td>{{$item['Quantity']}}</td>
                                <td>{{$item['Total']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>

           {{--  new column --}}
           <div>
            
                @php
                 
                      $categoryData = Stock::GroupCategoryBrandPlu($data, 1);
                @endphp
            
                <div class="">
                    <p class="uk-h4">DEPARTMENT SALES TOTAL</p>
                </div>
            
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            <th>Department</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categoryData as $key => $item)
                            <tr>
                                <td>{{$item['description']}}</td>
                                <td>{{$item['Quantity']}}</td>
                                <td>{{$item['Total']}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
            </div>



            <div>
            
                @php

                    $orderList = $data['orderList'];
                    $orderList = $orderList->groupBy('order_id');

                    foreach ($orderList as $receiptList) {
        
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                                $totalCostPrice = $totalCostPrice + $price;
                            }
                        }

                        $array100Sale[] = [
                                'time' => $receipt->created_at,
                                'order_id' => $receipt->order_id,
                                'store_id' =>  $receipt->store_name,
                                'total' => $totalCostPrice
                        ];

                    }
                @endphp

                <div class="">
                    <p class="uk-h4">LAST 100 SALES</p>
                </div>
            
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($array100Sale[0] as $key => $item)
                                <th>{{$key}}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($array100Sale as $keyArray100Sale => $itemArray100Sale)
                            <tr>
                                @foreach ($itemArray100Sale as $key => $item)
                                    <td>{{$item}}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            
            </div>


           
        </div>
       
    </div>


@endsection