@extends('layout.master')
@push('scripts')
    <script src="{{ asset('js/chart.js') }}"></script> 
@endpush
@php
    use App\Helpers\MathHelper;
    use App\Models\Order;
    use App\Models\Receipt;
    use App\Models\User;
    use Carbon\Carbon;

    $totalCostPrice = 0;
    $totalCash = 0;
    $totalCredit = 0;
    //->where('stock_cost', 'receipt.receipt_stock_cost_id')

   
   
    foreach ($data['orderList'] as $stockList) {
      
            if ($stockList->receipt_id) {
                $price = json_decode($stockList->stock_cost, true)[$stockList->receipt_stock_cost_id]['price'];
                $totalCostPrice = $totalCostPrice + $price;
            }
    }

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
@section('content')   




@if (User::UserType()[Auth::User()->user_type] == 'Super Admin' || User::UserType()[Auth::User()->user_type] == 'User')
    <div class="">
       
        <div>
            @include('dashboard.partial.datePeriodPartial')
        </div>

        {{-- first row --}}
        <div class="uk-margin uk-child-width-expand@l" uk-grid uk-height-match>
            <div>
                <div class="">
                    <p class="uk-h4">FIXED TOTALS</p>
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
            <div>           
                {{-- @include('dashboard.partial.orderTodayPartial', ['orderList' => $data['orderTodayList']]) --}}
            </div>

            <div>
                <div class="uk-width-medium@s">
                    <div class="uk-background-default uk-padding">
                        <p class="uk-h4 uk-margin-remove-bottom">Weekly Sales Stats</p>
                        <p class="uk-text-meta uk-margin-remove-top">
                            {{MathHelper::FloatRoundUp($data['currentWeekSale'] ,2)}}
                        </p>
                        <div>
                            <canvas id="currentWeekSalePercentage" width="800" height="1000"></canvas>
                        </div>
                    </div>
                    <div class="uk-background-default uk-padding">
                        <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-1@l" uk-grid>
                            <div>
                                <p class="uk-text-bold uk-margin-remove-bottom">
                                    <a class="uk-button uk-button-text" href="#">Most Sales</a>
                                </p>
                                <p class="uk-text-meta uk-margin-remove-top">
                                    Authors with the best sales
                                </p>
                            </div>
                            <div>
                                <p class="uk-text-bold uk-margin-remove-bottom">
                                    <a class="uk-button uk-button-text" href="#">Total Sales Lead</a>
                                </p>
                                <p class="uk-text-meta uk-margin-remove-top">
                                    <span id="currentWeekSalePercentageID">0</span>% increased on week-to-week reports    
                                </p>
                            </div>
                            <div>
                                <p class="uk-text-bold uk-margin-remove-bottom">
                                    <a class="uk-button uk-button-text" href="#">Average Bestseller</a>
                                </p>
                                <p class="uk-text-meta uk-margin-remove-top">
                                    Pitstop Email Marketing
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-width-expand@s uk-text-muted">           
                    @include('dashboard.partial.personnelPartial', ['orderList' => $data['orderTodayList']])
                </div>
            </div> 
        </div>
       
    </div>
@else
    <div class="uk-grid-meduim" uk-grid uk-height-match>
        <div class="uk-width-medium@s">
            <div class="uk-background-default uk-padding">
                <p class="uk-h4">FIXED TOTALS</p>
                <div>
                    <canvas id="monthlyYearlySale" width="800" height="1000"></canvas>
                </div>
            </div>
            <div class="uk-padding   uk-background-default ">
                <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-1@l" uk-grid>
                    <div>
                        <p class="uk-text-meta uk-margin-remove-bottom">Average Sale</p>
                        <p class="uk-text-bold uk-margin-remove-top">{{Order::AverageSale($data['orderList']->pluck('service_cost')->sum() , $data['orderList']->pluck('service_cost')->count())}}</p>
                    </div>
                    <div>
                        <p class="uk-text-meta uk-margin-remove-bottom">Commission</p>
                        <p class="uk-text-bold uk-margin-remove-top">{{Order::Commission($data['orderList']->pluck('service_cost')->sum() , $data['orderList']->pluck('service_commission_percentage')->sum())}}</p>
                    </div>
                    <div>
                        <p class="uk-text-meta uk-margin-remove-bottom">Annual Taxes</p>
                        <p class="uk-text-bold uk-margin-remove-top"></p>
                    </div>
                    <div>
                        <p class="uk-text-meta uk-margin-remove-bottom">Annual Income</p>
                        <p class="uk-text-bold uk-margin-remove-top">{{Order::AnnualIncome($data['orderList']->pluck('service_cost')->sum() , $data['orderList']->pluck('service_commission_percentage')->sum())}}</p>                       
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-expand@s">           
            {{-- @include('dashboard.partial.orderTodayPartial', ['orderList' => $data['orderTodayList']]) --}}
        </div>
    </div>
    {{-- second row --}}
    <div class="uk-grid-small" uk-grid uk-height-match>
        <div class="uk-width-medium@s">
            <div class="uk-background-default uk-padding">
                <p class="uk-h4 uk-margin-remove-bottom">Weekly Sales Stats</p>
                <p class="uk-text-meta uk-margin-remove-top">
                    {{MathHelper::FloatRoundUp($data['currentWeekSale'] ,2)}}
                </p>
                <div>
                    <canvas id="currentWeekSalePercentage" width="800" height="1000"></canvas>
                </div>
            </div>
            <div class="uk-background-default uk-padding">
                <div class="uk-grid-small uk-child-width-1-4@m uk-child-width-1-1@l" uk-grid>
                    <div>
                        <p class="uk-text-bold uk-margin-remove-bottom">
                            <a class="uk-button uk-button-text" href="#">Most Sales</a>
                        </p>
                        <p class="uk-text-meta uk-margin-remove-top">
                            Authors with the best sales
                        </p>
                    </div>
                    <div>
                        <p class="uk-text-bold uk-margin-remove-bottom">
                            <a class="uk-button uk-button-text" href="#">Total Sales Lead</a>
                        </p>
                        <p class="uk-text-meta uk-margin-remove-top">
                            <span id="currentWeekSalePercentageID">0</span>% increased on week-to-week reports    
                        </p>
                    </div>
                    <div>
                        <p class="uk-text-bold uk-margin-remove-bottom">
                            <a class="uk-button uk-button-text" href="#">Average Bestseller</a>
                        </p>
                        <p class="uk-text-meta uk-margin-remove-top">
                            Pitstop Email Marketing
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="uk-width-expand@s uk-text-muted">           
            @include('dashboard.partial.personnelPartial', ['orderList' => $data['orderTodayList']])
        </div>
    </div> 
@endif


@endsection