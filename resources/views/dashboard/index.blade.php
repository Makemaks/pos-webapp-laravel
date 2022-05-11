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

            {{-- Specials Manager --}}
            <div>

                @php
                @endphp

                <div class="">
                    <p class="uk-h4">SPECIALS MANAGER</p>
                </div>
                <hr>
                <h3 style="margin-top: 10vh !important;">INSTRUCTIONS FOR USE</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Nulla eos voluptatem recusandae doloremque
                    magnam, quidem voluptas ut id incidunt sunt temporibus sapiente exercitationem tenetur quos nobis at
                    earum nesciunt libero totam laudantium quae in et doloribus. Maxime voluptas iste maiores repellat
                    laboriosam mollitia non? Excepturi quaerat laborum tenetur blanditiis incidunt!</p>

            </div>

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
                <hr>

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
                <hr>

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
                <hr>

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

            {{-- Plu 0 sales --}}
            <div>

                @php
                    $pluData = Stock::GroupCategoryBrandPlu($data, 2);
                @endphp

                <div class="">
                    <p class="uk-h4">PLU SALES TOTAL</p>
                </div>
                <hr>

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
                <hr>

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


            {{-- last 100 sales --}}
            <div>

                @php
                    
                    $totalCostPrice = 0;
                    $price = 0;
                    
                    $orderList = $data['orderList'];
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
                <hr>

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
                <hr>

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

            {{-- EMPLOYEE TIME AND ATTENDANCE --}}

            <div>

                @php
                    
                @endphp

                <div class="">
                    <p class="uk-h4">EMPLOYEE TIME AND ATTENDANCE</p>
                </div>
                <hr>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            <th>Clerk</th>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

            {{-- HOURLY BREAKDOWN --}}

            <div>

                @php
                    
                @endphp

                <div class="">
                    <p class="uk-h4">HOURLY BREAKDOWN</p>
                </div>
                <hr>

                <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                    <thead>
                        <tr>
                            <th>Hour</th>
                            <th>Total</th>
                            <th>Sales</th>
                            <th>Avg</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>

            </div>

        </div>

    </div>
@endsection
