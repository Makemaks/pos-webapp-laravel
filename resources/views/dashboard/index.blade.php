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
        <div class="uk-margin uk-child-width-1-2@l" uk-grid uk-height-match style="margin-top: 5vh !important;">




            {{-- fixed totals --}}

            <div>

                @php
                    
                    $totalCostPrice = 0;
                    $price = 0;
                    $totalCash = 0;
                    $totalCredit = 0;
                    
                    $totalCostPrice = Stock::OrderTotal($data);
                    
                    $expenseTotal = $totalCostPrice - $data['expenseList']->sum('expense_amount');
                    
                    for ($i = 1; $i < count($data['settingModel']->setting_pos); $i++) {
                        $totalCashQuantity = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['quantity'];
                        $totalCashAmount = $totalCash + $data['settingModel']->setting_pos[$i]['cash']['amount'];
                    
                        $totalCreditQuantity = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['quantity'];
                        $totalCreditAmount = $totalCredit + $data['settingModel']->setting_pos[$i]['credit']['amount'];
                    }
                    
                    $totaliser = [
                        'NET sales' => ['Quantity' => $data['orderList']->count(), 'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2)],
                        'GROSS Sales' => ['Quantity' => $data['expenseList']->count(), 'Total' => MathHelper::FloatRoundUp($expenseTotal, 2)],
                        'CASH in Drawer' => ['Quantity' => $totalCashQuantity, 'Total' => MathHelper::FloatRoundUp($totalCashAmount, 2)],
                        'CREDIT in Drawer' => ['Quantity' => $totalCreditQuantity, 'Total' => MathHelper::FloatRoundUp($totalCreditAmount, 2)],
                        'TOTAL in Drawer' => ['Quantity' => $totalCashQuantity + $totalCreditQuantity, 'Total' => MathHelper::FloatRoundUp($totalCashAmount + $totalCreditAmount, 2)],
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
                                <td>{{ $key }}</td>
                                <td>{{ $item['Quantity'] }}</td>
                                <td>{{ $item['Total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- category 1 sales --}}
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
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['Quantity'] }}</td>
                                <td>{{ $item['Total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- group 0 sales --}}
            <div>

                @php
                    $groupData = Stock::GroupCategoryBrandPlu($data, 0);
                @endphp

                <div class="">
                    <p class="uk-h4">GROUP SALES TOTAL</p>
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
                        @foreach ($groupData as $key => $item)
                            <tr>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['Quantity'] }}</td>
                                <td>{{ $item['Total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- TOP CUSTOMERS --}}
            <div>

                @php
                    $totalCostPrice = 0;
                    $price = 0;
                    
                    $customerTop = $data['customerTop'];
                    $customerTop = $customerTop->groupBy('company_store_id');
                    
                    foreach ($customerTop as $receiptList) {
                        $person = $receiptList[0]->person_name;
                        $personName = json_decode($person);
                        $totalCostPrice = 0;
                        $price = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                                $totalCostPrice = $totalCostPrice + $price;
                            }
                        }
                    
                        $arraycustomerTop[] = [
                            'Account Num' => $receipt->company_store_id,
                            'Name' => $receipt->company_name,
                            'total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                        ];
                    }
                @endphp

                <div class="">
                    <p class="uk-h4">TOP CUSTOMERS</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
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



            {{-- Transaction Key --}}
            <div>

                @php
                    
                    $arraytransactionKey[] = [
                        'Description' => '',
                        'Quantity' => '',
                        'Total' => '',
                    ];
                    
                @endphp

                <div class="">
                    <p class="uk-h4">TRANSACTION KEY</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arraytransactionKey[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arraytransactionKey as $keyarraytransactionKey => $itemarraytransactionKey)
                            <tr>
                                @foreach ($itemarraytransactionKey as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>



            {{-- Clerk Breakdown --}}
            <div>

                @php
                    $totalCostPrice = 0;
                    $price = 0;
                    
                    $clerkBreakdown = $data['clerkBreakdown'];
                    $clerkBreakdown = $clerkBreakdown->groupBy('user_id');
                    
                    // dd($clerkBreakdown[2][0]->person_name, $clerkBreakdown[1][0]->person_name);
                    
                    foreach ($clerkBreakdown as $receiptList) {
                        $person = $receiptList[0]->person_name;
                        $personName = json_decode($person);
                        $totalCostPrice = 0;
                        $price = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                                $totalCostPrice = $totalCostPrice + $price;
                            }
                        }
                    
                        $arrayclerkBreakdown[] = [
                            'Number' => $receipt->receipt_user_id,
                            'Name' => $personName->person_preferred_name,
                            'total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                        ];
                    }
                @endphp

                <div class="">
                    <p class="uk-h4">CLERK BREAKDOWN</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arrayclerkBreakdown[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrayclerkBreakdown as $keyarrayclerkBreakdown => $itemarrayclerkBreakdown)
                            <tr>
                                @foreach ($itemarrayclerkBreakdown as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- FINALISE Key --}}
            <div>

                @php
                    
                    $arrayfinaliseKey[] = [
                        'Description' => '',
                        'Quantity' => '',
                        'Total' => '',
                    ];
                    
                @endphp

                <div class="">
                    <p class="uk-h4">FINALISE KEY</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arrayfinaliseKey[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrayfinaliseKey as $keyarrayfinaliseKey => $itemarrayfinaliseKey)
                            <tr>
                                @foreach ($itemarrayfinaliseKey as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>




            {{-- last 100 sales --}}
            <div>

                @php
                    
                    $totalCostPrice = 0;
                    $price = 0;
                    
                    $orderList = $data['orderListLimited100'];
                    
                    $orderList = $orderList->groupBy('order_id');
                    
                    foreach ($orderList as $receiptList) {
                        $totalCostPrice = 0;
                        $price = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                                $totalCostPrice = $totalCostPrice + $price;
                            }
                        }
                    
                        $array100Sale[] = [
                            'time' => $receipt->created_at,
                            'order_id' => $receipt->order_id,
                            'store_id' => $receipt->store_name,
                            'total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
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




            {{-- Specials Manager --}}
            <div>

                @php
                @endphp

                <div class="">
                    <p class="uk-h4">SPECIALS MANAGER</p>
                </div>
                <h6 style="">INSTRUCTIONS FOR USE</h6>
                <p style="font-size: 12px">The Specials Manager widget is designed to allow limite access users to edit
                    nominated fields of PLU's within defined PLU Ranges at a site level. <br> <br> To configure this widget
                    please select a site from the Site Selecter at the top of the page and then click the settings link in
                    the top right corner of this widget.</p>

            </div>


            {{-- EMPLOYEE TIME AND ATTENDANCE --}}

            <div>

                @php
                    
                    $arraytimeAndAttendance[] = [
                        'Clerk' => '',
                        'Date' => '',
                        'Time' => '',
                        'Status' => '',
                    ];
                    
                @endphp

                <div class="">
                    <p class="uk-h4">EMPLOYEE TIME AND ATTENDANCE</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arraytimeAndAttendance[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arraytimeAndAttendance as $keyarraytimeAndAttendance => $itemarraytimeAndAttendance)
                            <tr>
                                @foreach ($itemarraytimeAndAttendance as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- Plu 0 sales --}}
            <div>

                @php
                    $pluData = Stock::GroupCategoryBrandPlu($data, 2);
                @endphp

                <div class="">
                    <p class="uk-h4">PLU SALES TOTAL</p>
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
                        @foreach ($pluData as $key => $item)
                            <tr>
                                <td>{{ $item['description'] }}</td>
                                <td>{{ $item['Quantity'] }}</td>
                                <td>{{ $item['Total'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- HOURLY BREAKDOWN --}}

            <div>

                @php
                    
                    $totalCostPrice = 0;
                    $price = 0;
                    
                    $orderList = $data['orderListASC'];
                    $orderList = $orderList->groupBy('order_id');
                    
                    foreach ($orderList as $key => $receiptList) {
                        $totalCostPrice = 0;
                        $price = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $defaultPrice = json_decode($receipt->stock_cost, true);
                    
                                foreach ($defaultPrice as $key1 => $value) {
                                    if ($value['default'] == 0) {
                                        $totalCostPrice = $totalCostPrice + $value['price'];
                                    }
                                }
                            }
                        }
                    
                        $orderList = Order::where('order_store_id', $data['userModel']->store_id)->get();
                    
                        foreach ($orderList as $orderArray) {
                            if ($key == $orderArray->order_id) {
                                $firstKey = $orderList->first();
                                $firstOrderHour = (int) $firstKey->created_at->format('H'); // first order hour
                                $orderHour = (int) $orderArray->created_at->format('H');
                                $displayHour = $orderArray->created_at->format('H:i');
                    
                                if ($firstOrderHour == $orderHour) {
                                    // if its first order
                    
                                    $tableHour = $orderHour;
                                    $previousHour = $orderHour;
                                    $averageSales = 0;
                                    $averageSales = $totalCostPrice;
                                } else {
                                    // if its not first order
                    
                                    $tableHour = $orderHour - $previousHour;
                                    $previousHour = $orderHour;
                                    $averageSales = 0;
                                    $averageSales = $totalCostPrice / $tableHour;
                                }
                    
                                $arrayhourlyBreakdown[] = [
                                    'Hour' => $displayHour,
                                    'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                                    'Sales' => $receiptList->count(),
                                    'Avg. Sales' => MathHelper::FloatRoundUp($averageSales, 2),
                                ];
                            }
                        }
                    }
                    
                @endphp

                <div class="">
                    <p class="uk-h4">HOURLY BREAKDOWN</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arrayhourlyBreakdown[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrayhourlyBreakdown as $keyarrayhourlyBreakdown => $itemarrayhourlyBreakdown)
                            <tr>
                                @foreach ($itemarrayhourlyBreakdown as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- SALES BREAKDOWN BY SITE --}}
            <div>

                @php
                    $totalCostPrice = 0;
                    $price = 0;
                    
                    $orderList = $data['orderList'];
                    $orderList = $orderList->groupBy('store_id');
                    
                    foreach ($orderList as $receiptList) {
                        $totalCostPrice = 0;
                        $price = 0;
                        $i = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                                $totalCostPrice = $totalCostPrice + $price;
                    
                                $i++;
                            }
                        }
                    
                        $arraySiteBreakdown[] = [
                            'Number' => $receipt->store_id,
                            'Site' => $receipt->store_name,
                            'Sales' => $receiptList->count(),
                            'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                        ];
                    }
                    
                @endphp

                <div class="">
                    <p class="uk-h4"> SALES BREAKDOWN BY SITE</p>
                </div>

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


            {{-- STOCK SEARCH --}}


            {{-- HOURLY BREAKDOWN --}}

            <div>

                @php
                    
                    $arraystockSearch[] = [
                        'Stock Name' => '',
                        'Sales' => '',
                        'Total' => '',
                    ];
                    
                @endphp
                <div class="">
                    <p class="uk-h4">STOCK SEARCH</p>
                </div>


                <div class="uk-margin">
                    <form class="uk-search uk-search-default">
                        <a href="" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input" type="search" placeholder="Search">
                    </form>
                </div>
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
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

            </div>


            {{-- PENDING UPDATES --}}
            <div>

                @php
                    
                    $arraypendingUpdates[] = [
                        'Site' => '',
                        'Pending' => '',
                        'Last Updated' => '',
                    ];
                    
                @endphp
                <div class="">
                    <p class="uk-h4">PENDING UPDATES</p>
                </div>
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arraypendingUpdates[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arraypendingUpdates as $keyarraypendingUpdates => $itemarraypendingUpdates)
                            <tr>
                                @foreach ($itemarraypendingUpdates as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            {{-- EAT IN EAT OUT --}}
            <div>

                @php
                    
                    $arrayeatInEatOut[] = [
                        'Order Type' => '',
                        'Quantity' => '',
                        'Date' => '',
                    ];
                    
                @endphp
                <div class="">
                    <p class="uk-h4">EAT IN EAT OUT</p>
                </div>
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
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

            </div>


            {{-- LAST Z READ --}}
            <div>

                @php
                    
                    $arrayLastZRead[] = [
                        'Site' => '',
                        'Last Z Read' => '',
                    ];
                    
                @endphp
                <div class="">
                    <p class="uk-h4">LAST Z READ</p>
                </div>
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arrayLastZRead[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrayLastZRead as $keyarrayLastZRead => $itemarrayLastZRead)
                            <tr>
                                @foreach ($itemarrayLastZRead as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>

            {{-- GP SALES --}}
            <div>

                @php
                    
                    $orderList = $data['orderList'];
                    $orderList = $orderList->groupBy('stock_id');
                    
                    // dd($orderList[2][0]);
                    
                    foreach ($orderList as $receiptList) {
                        $totalCostPrice = 0;
                        $price = 0;
                        $totalStockNet = 0;
                        $totalactualPrice = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $defaultPrice = json_decode($receipt->stock_cost, true);
                                $actualPrice = json_decode($receipt->stock_gross_profit, true);
                                $stockNameJson = json_decode($receipt->stock_merchandise, true);
                                $stockName = $stockNameJson['stock_name'];
                    
                                foreach ($defaultPrice as $key => $value) {
                                    if ($value['default'] == 0) {
                                        $totalStockNet = $totalStockNet + $value['price'];
                                    }
                                }
                    
                                $totalactualPrice = $totalactualPrice + $actualPrice['actual'];
                                $quantity = $receiptList->count();
                            }
                        }
                    
                        $totalGP = $totalStockNet - $totalactualPrice;
                    
                        $GPpercentage = ($totalGP / $quantity) * 100;
                    
                        $arrayGPList[] = [
                            'Number' => $receipt->stock_id,
                            'Descriptor' => $stockName,
                            'Profit' => MathHelper::FloatRoundUp($totalGP, 2),
                            'GP' => MathHelper::FloatRoundUp($GPpercentage, 2) . '%',
                        ];
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
                    
                @endphp
                <div class="">
                    <p class="uk-h4">GP SALES</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">

                    <thead>
                        <td>
                            <h5>Top GP %</h5>
                        </td>
                    </thead>
                    <thead>
                        <tr>
                            @foreach ($arrayGPList[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($topGPList as $keyarrayGPList => $itemarrayGPList)
                            <tr>
                                @foreach ($itemarrayGPList as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>

                    <thead>
                        <td>
                            <h5>Bottom GP %</h5>
                        </td>
                    </thead>

                    <thead>
                        <tr>
                            @foreach ($arrayGPList[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bottomGPListASC as $keyarrayGPList => $itemarrayGPList)
                            <tr>
                                @foreach ($itemarrayGPList as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>


            {{-- GP OVERVIEW --}}
            <div>

                @php
                    
                    $orderList = $data['orderList'];
                    $orderList = $orderList->groupBy('store_id');
                    
                    foreach ($orderList as $receiptList) {
                        $totalCostPrice = 0;
                        $price = 0;
                        $totalStockProfit = 0;
                        $totalactualPrice = 0;
                    
                        foreach ($receiptList as $receipt) {
                            if ($receipt->receipt_id) {
                                $defaultPrice = json_decode($receipt->stock_cost, true);
                                $actualPrice = json_decode($receipt->stock_gross_profit, true);
                    
                                foreach ($defaultPrice as $key => $value) {
                                    if ($value['default'] == 0) {
                                        $totalStockProfit = $totalStockProfit + $value['price'];
                                    }
                                }
                    
                                $totalactualPrice = $totalactualPrice + $actualPrice['actual'];
                    
                                $quantity = $receiptList->count();
                            }
                        }
                    
                        // dd($totalStockProfit, $totalactualPrice, $quantity);
                    
                        $totalGP = $totalStockProfit - $totalactualPrice;
                    
                        $GPpercentage = ($totalGP / $quantity) * 100;
                    
                        $arrayGPOverview[] = [
                            'GP %' => MathHelper::FloatRoundUp($GPpercentage, 2) . '%',
                            'Total GP' => MathHelper::FloatRoundUp($totalGP, 2),
                        ];
                    }
                    
                @endphp

                <div class="">
                    <p class="uk-h4"> GP OVERVIEW</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($arrayGPOverview[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arrayGPOverview as $keyarrayGPOverview => $itemarrayGPOverview)
                            <tr>
                                @foreach ($itemarrayGPOverview as $key => $item)
                                    <td>{{ $item }}</td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

    </div>
@endsection
