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
                    
                    $totalCostPrice = Stock::OrderTotal($data['orderList']);
                    
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
                    
                    if (count($customerTop) > 0) {
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
                    } else {
                        $arraycustomerTop[] = [
                            'Account Num' => '',
                            'Name' => '',
                            'total' => '',
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
                    
                    if (count($clerkBreakdown) > 0) {
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
                                'Name' => $personName->person_firstname,
                                'total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                            ];
                        }
                    } else {
                        $arrayclerkBreakdown[] = [
                            'Number' => '',
                            'Name' => '',
                            'total' => '',
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
                @endphp

                @php
                    
                    $setting_model = $data['settingModel'];
                    $orderList = $data['orderList'];
                    $orderList = $orderList->groupBy('order_id');
                    
                    foreach ($setting_model->setting_key_type as $key => $setting) {
                        $table[$key] = [
                            'name' => $setting,
                            'quantity' => 0,
                            'total' => 0,
                        ];
                    }
                    
                    $quantity20 = 0;
                    $total20 = 0;
                    $key20 = 0;
                    $key20 = count($table) + 1;
                    
                    foreach ($orderList as $key => $order) {
                        $order_finalise_key_value = json_decode($order->first()->order_finalise_key, true);
                    
                        foreach ($order_finalise_key_value as $key => $order_key) {
                            // $order_key['ref'] => 2,2,3,7,4
                            foreach ($setting_model->setting_key as $settingKey => $value) {
                                if (array_key_exists($value['setting_key_type'], $table) && $order_key['ref'] == $settingKey && $value['value'] != null) {
                                    //
                    
                                    $table[$value['setting_key_type']]['total'] = $order_key['total'] + $table[$value['setting_key_type']]['total'];
                                    $table[$value['setting_key_type']]['quantity'] = $table[$value['setting_key_type']]['quantity'] + 1;
                    
                                    if ($value['value'] == 20) {
                                        $quantity20 = $order_key['total'] / $value['value'] + $quantity20;
                                        $total20 = $total20 + $order_key['total'];
                    
                                        $table[$key20] = [
                                            'name' => '20 Pound',
                                            'quantity' => MathHelper::FloatRoundUp($quantity20, 0),
                                            'total' => $total20,
                                        ];
                                    }
                                }
                    
                                if (array_key_exists($value['setting_key_type'], $table) && $order_key['ref'] == $settingKey && $value['setting_key_type'] == 2) {
                                    // IF ITS CREDIT
                    
                                    $table[$value['setting_key_type']]['total'] = $order_key['total'] + $table[$value['setting_key_type']]['total'];
                                    $table[$value['setting_key_type']]['quantity'] = $table[$value['setting_key_type']]['quantity'] + 1;
                                }
                    
                                if (array_key_exists($value['setting_key_type'], $table) && $order_key['ref'] == $settingKey && $value['setting_key_type'] == 3) {
                                    // IF ITS VOUCHER
                                    // take away user voucher credit
                                }
                            }
                        }
                    }
                    
                @endphp

                <div class="">
                    <p class="uk-h4">FINALISE KEY</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach ($table[1] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($table as $keytable => $itemtable)
                            <tr>
                                @foreach ($itemtable as $key => $item)
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
                    
                    $orderList = $data['orderListASC'];
                    
                    $orderList = $orderList->groupBy('order_id');
                    
                    if (count($orderList) > 0) {
                        foreach ($orderList as $receiptList) {
                            $totalCostPrice = 0;
                            $price = 0;
                            $current_created_at = Order::find($receiptList->first()->order_id)->created_at;
                    
                            foreach ($receiptList as $receipt) {
                                if ($receipt->receipt_id) {
                                    $price = json_decode($receipt->stock_cost, true)[$receipt->receipt_stock_cost_id]['price'];
                                    $totalCostPrice = $totalCostPrice + $price;
                                }
                            }
                    
                            $array100Sale[] = [
                                'time' => $current_created_at,
                                'order_id' => $receipt->order_id,
                                'total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
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
                                    $setting_stock_group_category_plu = json_decode($receipt->setting_stock_group_category_plu, true);
                                    $kpcat = $setting_stock_group_category_plu[$category_id]['description'];
                    
                                    // price 1 and 2
                                    $stock_cost = json_decode($receipt->stock_cost, true);
                                    $price_1 = $stock_cost[1]['price'];
                                    $price_2 = $stock_cost[2]['price'];
                                }
                            }
                    
                            $arraySpecialsManager[] = [
                                'PLU' => $stockId,
                                'NAME' => $stockName,
                                'PRICE1L1' => MathHelper::FloatRoundUp($price_1, 2),
                                'PRICE2L2' => MathHelper::FloatRoundUp($price_2, 2),
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

                @if ($arraySpecialsManager[0]['PLU'] !== '')
                    <div class="">
                        <p class="uk-h4">SPECIALS MANAGER</p>
                    </div>

                    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
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
                    <div class="">
                        <p class="uk-h4">SPECIALS MANAGER</p>
                    </div>
                    <h6 style="">INSTRUCTIONS FOR USE</h6>
                    <p style="font-size: 12px">The Specials Manager widget is designed to allow limited access users to edit
                        nominated fields of PLU's within defined PLU Ranges at a site level. <br> <br> To configure this
                        widget
                        please select a site from the Site Selecter at the top of the page and then click the settings link
                        in
                        the top right corner of this widget.</p>
                @endif

            </div>


            {{-- EMPLOYEE TIME AND ATTENDANCE --}}

            <div>

                @php
                    
                    $orderList = $data['orderList'];
                    $orderList = $orderList->groupBy('user_id');
                    
                    foreach ($orderList as $userId => $receiptList) {
                        $clerkName = json_decode($receiptList[0]->person_name, true)['person_firstname'];
                        $attendance = json_decode($receiptList[0]->attendance, true);
                        $attendance_status = end($attendance)['status'];
                        if ($attendance_status == 0) {
                            $attendance_status = 'Clocked in';
                        } else {
                            $attendance_status = 'Clocked out';
                        }
                        $attendance_date = Carbon::parse(end($attendance)['at'])->format('d/m/Y');
                        $attendance_time = Carbon::parse(end($attendance)['at'])->format('H:i:s');
                    
                        $arraytimeAndAttendance[$userId] = [
                            'Clerk' => $clerkName,
                            'Date' => $attendance_date,
                            'Time' => $attendance_time,
                            'Status' => $attendance_status,
                        ];
                    }
                    
                @endphp

                <div class="">
                    <p class="uk-h4">EMPLOYEE TIME AND ATTENDANCE</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            @foreach (array_values($arraytimeAndAttendance)[0] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($arraytimeAndAttendance as $keyarraytimeAndAttendance => $itemarraytimeAndAttendance)
                            <tr
                                @if ($itemarraytimeAndAttendance['Status'] === 'Clocked in') class="uk-text-success" @else class="uk-background-muted" @endif>
                                @foreach ($itemarraytimeAndAttendance as $key => $item)
                                    <td> {{ $item }}</td>
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
                    $orderList = $data['orderHourly'];
                    $orderList = $orderList->groupBy('order_id');
                    
                    if (count($orderList) > 0) {
                        $count = 0;
                        $orderArray = [];
                    
                        $averageSales = 0;
                        $nowCarbon = Carbon::now();
                    
                        $current_minute = $nowCarbon->setTime(0, 0, 0);
                    
                        $i = 0;
                    
                        for ($i = 0; $i < 96; $i++) {
                            $count++;
                    
                            $totalCostPrice = 0;
                            $averageSales = 0;
                            $totalQuantity = 0;
                            if ($i == 0) {
                                $current_minute = Carbon::now()->setTime(0, 0, 0);
                                $price_each_order = 0;
                                $quantity_each_order = 0;
                                $averageSales = 0;
                            } else {
                                $current_minute = $current_minute->copy()->addMinutes(15);
                                $previous_minute = $current_minute->copy()->subMinutes(15);
                    
                                foreach ($orderList as $key => $receiptList) {
                                    $current_order_minute = Order::find($receiptList->first()->order_id)->created_at->format('H:i');
                    
                                    $current_order_minute_carbon = Carbon::parse($current_order_minute);
                    
                                    if ($current_order_minute_carbon->gte($previous_minute) && $current_order_minute_carbon->lt($current_minute)) {
                                        $price_each_order = Stock::OrderTotal($receiptList);
                                        $quantity_each_order = $receiptList->count();
                                        $totalQuantity = $totalQuantity + $quantity_each_order;
                                        $totalCostPrice = $totalCostPrice + $price_each_order;
                                    } else {
                                        $price_each_order = 0;
                                        $quantity_each_order = 0;
                                        $averageSales = 0;
                    
                                        $totalQuantity = $totalQuantity + $quantity_each_order;
                                        $totalCostPrice = $totalCostPrice + $price_each_order;
                                    }
                    
                                    if ($totalQuantity != 0) {
                                        $averageSales = $totalCostPrice / $totalQuantity;
                                    } else {
                                        $averageSales = 0;
                                    }
                                }
                            }
                    
                            $orderArrayTable[$i] = [
                                'Hour' => $current_minute->format('H:i'),
                                'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
                                'Sales' => $totalQuantity,
                                'Average Sales' => MathHelper::FloatRoundUp($averageSales, 2),
                            ];
                        }
                    } else {
                        $orderArrayTable[1] = [
                            'Hour' => '',
                            'Total' => '',
                            'Sales' => '',
                            'Average Sales' => '',
                        ];
                    }
                @endphp

                <div class="">
                    <p class="uk-h4">HOURLY BREAKDOWN (by today)</p>
                </div>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
                    <thead>
                        <tr>
                            @foreach ($orderArrayTable[1] as $key => $item)
                                <th>{{ $key }}</th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderArrayTable as $keyorderArrayTable => $itemorderArrayTable)
                            <tr>
                                @foreach ($itemorderArrayTable as $key => $item)
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
                    
                    if (count($orderList) > 0) {
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
                    } else {
                        $arraySiteBreakdown[] = [
                            'Number' => '',
                            'Site' => '',
                            'Sales' => '',
                            'Total' => '',
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
            <div>

                @php
                    
                    $stockList = $data['orderList'];
                    $stockList = $stockList->groupBy('stock_id');
                    
                    if (count($stockList) > 0) {
                        foreach ($stockList as $key => $receiptList) {
                            foreach ($receiptList as $receipt) {
                                if ($receipt->receipt_id) {
                                    $stockNameJson = json_decode($receipt->stock_merchandise, true);
                                    $stockName = $stockNameJson['stock_name'];
                    
                                    $totalCostPrice = Stock::OrderTotal($receiptList);
                                    $quantity_each_stock = $receiptList->count();
                                }
                            }
                    
                            $arraystockSearch[] = [
                                'Stock Name' => $stockName,
                                'Sales' => $quantity_each_stock,
                                'Total' => MathHelper::FloatRoundUp($totalCostPrice, 2),
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
                <div class="">
                    <p class="uk-h4">STOCK SEARCH</p>
                </div>


                <div class="uk-margin">
                    <form class="uk-search uk-search-default">
                        <a href="" class="uk-search-icon-flip" uk-search-icon></a>
                        <input class="uk-search-input" type="search" placeholder="Search">
                    </form>
                </div>
                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
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
                    
                    if (count($orderList) > 0) {
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
                    } else {
                        $arrayGPList[] = [
                            'Number' => '',
                            'Descriptor' => '',
                            'Profit' => '',
                            'GP' => '',
                        ];
                        $topGPList[] = [
                            'Number' => '',
                            'Descriptor' => '',
                            'Profit' => '',
                            'GP' => '',
                        ];
                        $bottomGPList[] = [
                            'Number' => '',
                            'Descriptor' => '',
                            'Profit' => '',
                            'GP' => '',
                        ];
                        $bottomGPListASC[] = [
                            'Number' => '',
                            'Descriptor' => '',
                            'Profit' => '',
                            'GP' => '',
                        ];
                    }
                    
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
                    
                    if (count($orderList) > 0) {
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
                    } else {
                        $arrayGPOverview[] = [
                            'GP %' => '',
                            'Total GP' => '',
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
