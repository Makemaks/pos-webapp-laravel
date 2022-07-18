@push('scripts')
    <script src="{{ asset('js/gateway.js') }}"></script>
@endpush

@php
    use App\Helpers\NumpadHelper;
    use App\Helpers\StringHelper;
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
  
    use App\Models\Person;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Receipt;

    $currency = "";
    $receipt['deliveryTotal']=0;
    $receipt['voucherAmountTotal']=0;
    $receipt['voucherPercentageTotal']=0;
    $receipt['discountAmountTotal']=0;
    $receipt['discountPercentageTotal']=0;
    $receipt['creditTotal'] = 0;
    $receipt['cashTotal'] = 0;
    $receipt['totalPriceVAT'] = 0;
    $receipt['totalPrice'] = 0;
    $receipt['subTotal'] = 0;
    $receipt['totalPriceFinal'] = 0;
    

   
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

   
    if(Session::has('user-session-'.Auth::user()->user_id. '.cartList') && isset($stockList) == false){
       
        $data['sessionCartList'] = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
        
        $stockList = Receipt::SessionDisplay($data['sessionCartList']);
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
                        <th></th>
                    @else
                        <th class="uk-width-expand"></th>
                    @endif
                </tr>
            </thead>
            <tbody id="cartListID" class="uk-overflow-auto">
                @isset ($stockList)
               
                    @foreach ($stockList as $stockKey => $stockItem)
                        @php
                            $receipt = Receipt::Calculate( $data, $stockItem, $loop, $receipt );
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
                                        @if ($receipt['stock_vat_rate'])
                                            {{ MathHelper::FloatRoundUp($receipt['stock_vat_rate'], 2)}}
                                        @endif
                                    </td>
        
                                    <td>
                                       @if ($stockItem['stock_discount'])
                                            {{$stockItem['stock_discount']}}
                                       @endif
                                    </td>
        
                                    <td>
                                        {{ MathHelper::FloatRoundUp( $receipt['price'], 2) }}
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

        @if ($receipt['cashTotal'] > 0)
            
            <div class="uk-margin-remove-top">Cash {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList()"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['cashTotal'])}}</div>
           
        @endif

        @if ($receipt['creditTotal'] > 0)
            
            <div class="uk-margin-remove-top">Credit {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('credit')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['discountTotal'])}}</div>
           
        @endif

        @if ($receipt['voucherAmountTotal'] > 0)
            
            <div class="uk-margin-remove-top">Voucher {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('voucher')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['voucherAmountTotal'])}}</div>
           
        @endif

        @if ($receipt['voucherPercentageTotal'] > 0)
            
            <div class="uk-margin-remove-top">Voucher %{{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('voucher')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['voucherPercentageTotal'])}}</div>
           
        @endif
            
        @if ($receipt['discountAmountTotal'] > 0)
            
            <div class="uk-margin-remove-top">Discount{{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('discount')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top"> - {{CurrencyHelper::Format($receipt['discountAmountTotal'])}}</div>
           
        @endif

        @if ($receipt['discountPercentageTotal'] > 0)
            
            <div class="uk-margin-remove-top">Discount %{{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('discount')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['discountPercentageTotal'])}}</div>
        
        @endif

        @if ($receipt['deliveryTotal'] > 0)
          
            <div class="uk-margin-remove-top">Delivery {{$currency}}
                <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('delivery')"></span>
            </div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['deliveryTotal'])}}</div>
         
        @endif

        @isset ($receipt['totalSettingVAT'])
          
            <div class="uk-margin-remove-top">VAT % {{MathHelper::FloatRoundUp($receipt['totalSettingVAT'], 2)}}</div>
            <div class="uk-text-right uk-margin-remove-top">{{MathHelper::FloatRoundUp($receipt['totalPriceVAT'] - $receipt['subTotal'], 2)}}</div>
           
        @endisset

       
        <div class="uk-margin-remove-top">Sub Total {{$currency}}</div>
        <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($receipt['subTotal'])}}</div>
    
        <div class="uk-margin-remove-top uk-text-bold">Total {{$currency}}</div>
        <div class="uk-text-right uk-margin-remove-top uk-text-bold">{{CurrencyHelper::Format($receipt['totalPriceFinal'])}}</div>
        
    </div>
    
   
</div>