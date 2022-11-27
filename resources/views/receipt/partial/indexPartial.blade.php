@push('scripts')
    <script src="{{ asset('js/gateway.js') }}"></script>
@endpush

@php
    use App\Helpers\NumpadHelper;
    use App\Helpers\StringHelper;
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
  
    use App\Models\Setting;
    use App\Models\Person;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Receipt;

    $route = Str::before(Request::route()->getName(), '.'); 
    $currencySymbol = Setting::SettingCurrency($data);

    $currency = "";
  
    if ( Session::has('user-session-'.Auth::user()->user_id.'.'.'setupList')) {
        $setupList = Session::get('user-session-'.Auth::user()->user_id. '.setupList');
    }

   
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

   
    if(Session::has('user-session-'.Auth::user()->user_id. '.cartList') && isset($stockList) == false){
       
        $data['sessionCartList'] = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
        
        $stockList = Receipt::SessionCartInitialize($data['sessionCartList']);
    }

  
@endphp

@include('receipt.partial.receiptMenuPartial')

<div class="" uk-height-viewport="offset-top: true; offset-bottom: 50px">
    <div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th class="uk-width-auto"></th>
                    @if (Session::has('edit_cart')==false)
                        <th>VAT</th>
                        <th>Discount</th>
                        <th>{{$currencySymbol}}</th>
                    @else
                        <th class="uk-width-expand"></th>
                    @endif
                </tr>
            </thead>
            <tbody id="cartListID" class="uk-overflow-auto">
                @isset ($stockList)
               
                    @foreach ($stockList as $stockKey => $stockItem)
                        @php
                            $setupList = Receipt::Calculate( $data, $stockItem, $loop, $setupList );
                            Session::pull('user-session-'.Auth::user()->user_id.'.'.'setupList');
                            Session::put('user-session-'.Auth::user()->user_id.'.'.'setupList', $setupList);
                            $stockPriceQuantity = Stock::StockPriceQuantity($stockItem);
                        @endphp
                        
                            <tr id="cartItemID-{{$loop->index}}">
                                <td>
                                    
                                    {{$stockItem['stock_name']}} 
                                    @if ($stockItem['stock_quantity'] > 1)
                                        <span class="uk-text-meta uk-text-top"> {{$stockItem['stock_quantity']}}</span>
                                    @endif
                                </td>
    
                                @if (Session::has('edit_cart')==false)
                                    <td>
                                        @if ($setupList['receipt']['stock_vat_rate'])
                                            {{ MathHelper::FloatRoundUp($setupList['receipt']['stock_vat_rate'], 2)}}
                                        @endif
                                    </td>
        
                                    <td>
                                       @if ($stockItem['stock_discount'])
                                            {{ Stock::Discount($stockPriceQuantity, $stock_discount['type'], $stock_discount['value']) }}
                                       @endif
                                    </td>
        
                                    <td>
                                        {{ MathHelper::FloatRoundUp( $stockPriceQuantity, 2) }}
                                    </td>
                                @else
                                    <td>

                                        @include('partial.controlPartial',
                                        [
                                            'cartValue' => $loop->index,
                                            'quantity' => $stockItem['stock_quantity']
                                        ])
                                    </td>
                                @endif

                            </tr>
                    @endforeach
    
                @endisset
            </tbody>
            
        </table>
    </div>
    
    <div class="uk-margin-large uk-child-width-1-2@m" uk-grid>

        @if ($setupList['receipt']['cashTotal'] > 0)
            
            <div class="uk-margin-remove-top">Cash {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('cash')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['cashTotal'])}}</div>
           
        @endif

        @if ($setupList['receipt']['creditTotal'] > 0)
            
            <div class="uk-margin-remove-top">Credit {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('credit')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['discountTotal'])}}</div>
           
        @endif

        @if ($setupList['receipt']['voucherAmountTotal'] > 0)
            
            <div class="uk-margin-remove-top">Voucher {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('voucher')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['voucherAmountTotal'])}}</div>
           
        @endif

        @if ($setupList['receipt']['voucherPercentageTotal'] > 0)
            
            <div class="uk-margin-remove-top">Voucher %{{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('voucher')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['voucherPercentageTotal'])}}</div>
           
        @endif
            
        @if ($setupList['receipt']['discountAmountTotal'] > 0)
            
            <div class="uk-margin-remove-top">Discount{{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('discount')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top"> - {{CurrencyHelper::Format($setupList['receipt']['discountAmountTotal'])}}</div>
           
        @endif

        @if ($setupList['receipt']['discountPercentageTotal'] > 0)
            
            <div class="uk-margin-remove-top">Discount %{{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('discount')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['discountPercentageTotal'])}}</div>
        
        @endif

        @if ($setupList['receipt']['deliveryTotal'] > 0)
          
            <div class="uk-margin-remove-top">Delivery {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('delivery')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['deliveryTotal'])}}</div>
         
        @endif

        @isset ($setupList['receipt']['totalSettingVAT'])
          
            <div class="uk-margin-remove-top">VAT % {{MathHelper::FloatRoundUp($setupList['receipt']['totalSettingVAT'], 2)}}</div>
            <div class="uk-text-right uk-margin-remove-top">{{MathHelper::FloatRoundUp($setupList['receipt']['totalPriceVAT'] - $setupList['receipt']['subTotal'], 2)}}</div>
           
        @endisset

       
        <div class="uk-margin-remove-top">Sub Total {{$currency}}</div>
        <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($setupList['receipt']['subTotal'])}}</div>
    
        <div class="uk-margin-remove-top uk-text-bold">Total {{$currency}}</div>
        <div class="uk-text-right uk-margin-remove-top uk-text-bold">{{CurrencyHelper::Format($setupList['receipt']['totalPriceFinal'])}}</div>
        
    </div>
    
   
</div>
