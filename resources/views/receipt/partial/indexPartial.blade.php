@push('scripts')
    <script src="{{ asset('js/gateway.js') }}"></script>
@endpush

@php

    use App\Helpers\NumpadHelper;
    use App\Helpers\StringHelper;
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\KeyHelper;

    use App\Models\Setting;
    use App\Models\Person;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Receipt;

    $route = Str::before(Request::route()->getName(), '.'); 
    $currencySymbol = Setting::SettingCurrency($data);
    $openControlID = '';
    $closeControlID = 'hidden';
    $currency = "";
  
    if ( Session::has('user-session-'.Auth::user()->user_id.'.'.'setupList')) {
        $data['setupList'] = Session::get('user-session-'.Auth::user()->user_id. '.setupList');
    }
   
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

   
    if(Session::has('user-session-'.Auth::user()->user_id. '.cartList') && isset($stockList) == false){
       
        $data['sessionCartList'] = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
        
        $stockList = Receipt::SessionCartInitialize($data['sessionCartList']);
    }
  
@endphp

@include('receipt.partial.receiptMenuPartial')

<form action="" id="cartFormID" method="POST">
    <div uk-height-viewport="offset-top: true; offset-bottom: 50px">
        <div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
            <table class="uk-table uk-table-small uk-table-divider">
                <thead>
                    <tr>
                        <th>
                            <input type="checkbox" value="" class="uk-checkbox" onclick="SelectAll(this, cartListID)">
                            {{-- <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" onclick="control(0)" uk-icon="pencil" {{$openControlID}}></button>
                            <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" onclick="control(1)" uk-icon="close" id="controlHideID" {{$closeControlID}}></button> --}}
                        </th>
                        <th>VAT</th>
                        <th>DISCOUNT</th>
                        <th>{{$currencySymbol}}</th>
                       
                    </tr>
                </thead>
                <tbody id="cartListID" class="uk-overflow-auto">
                    @isset ($stockList)
                   
                        @foreach ($stockList as $stockKey => $stockItem)
                            @php
                                $data = Receipt::Calculate( $data, $stockItem, $loop );
                                Session::pull('user-session-'.Auth::user()->user_id.'.'.'setupList');
                                Session::put('user-session-'.Auth::user()->user_id.'.'.'setupList', $data['setupList']);
    
                                $cartList = Session::pull('user-session-'.Auth::user()->user_id.'.'.'cartList');
                                $cartList[$loop->index]['stock_price'] = $data['setupList']['receipt']['stock']['stock_price_processed'];
                                Session::put('user-session-'.Auth::user()->user_id.'.'.'cartList', $cartList);
                                
                            @endphp
                            
                                <tr id="cartItemID-{{$loop->index}}">
                                    <td>
                                        <input type="checkbox" name="receipt_stock_id[]" value="{{$stockItem['stock_id']}}" class="uk-checkbox">
                                    </td>
    
                                    <td>
                                      
                                        <button class="uk-button uk-button-text" uk-toggle="target: #toggle-stock-{{$loop->index}}">
                                            {{$stockItem['stock_name']}} 
                                            @if ($stockItem['stock_quantity'] > 1)
                                                <span class="uk-text-meta uk-text-top"> {{$stockItem['stock_quantity']}}</span>
                                            @endif
                                        </button>
                                        
                                    </td>
        
                                    
                                    <td>
                                        @if ($data['setupList']['receipt']['stock_vat_rate'])
                                            {{ MathHelper::FloatRoundUp($data['setupList']['receipt']['stock_vat_rate'], 2)}}
                                        @endif
                                    </td>
        
                                    <td>
                                        @if ($stockItem['stock_discount'])
                                            {{-- {{ Stock::Discount($stockPriceQuantity, $stock_discount['type'], $stock_discount['value']) }} --}}
                                        @endif
                                    </td>
        
                                    <td>
                                        @if ($data['setupList']['receipt']['stock']['stock_price_processed'])
                                            {{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock']['stock_price_processed'], 2) }}    
                                        @else
                                            {{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock']['stock_price'], 2) }}    
                                        @endif
                                    </td>
                                  
                                </tr>
    
                                {{-- <tr id="toggle-stock-{{$loop->index}}" hidden>
                                    <td colspan="5">
                                        @include('receipt.partial.controlPartial',
                                            [
                                                'cartValue' => $loop->index,
                                                'quantity' => $stockItem['stock_quantity']
                                            ])
                                    </td>
                                </tr> --}}
                        @endforeach
        
                    @endisset
                </tbody>
                
            </table>
    
            {{-- @if (count($data['setupList']['order_setting_key']) > 0)
                <table class="uk-table uk-table-small uk-table-divider">
                        <thead>
                            <tr>
                                <th>NAME</th>
                                <th>VALUE</th>
                                <th>GROUP</th>
                                <th>TYPE</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['setupList']['order_setting_key'] as $order_setting_key)
                                <tr>
                                    <td>
                                        <button class="uk-button uk-button-text" uk-toggle="target: #toggle-orderFinaliseKey-{{$loop->index}}">
                                            {{$order_setting_key['name']}}
                                        </button>
                                    </td>
                                    <td>{{$order_setting_key['value']}}</td>
                                    <td>{{ Str::upper(Setting::SettingKeyGroup()[$order_setting_key['setting_key_group']]) }}</td>
                                    <td>{{KeyHelper::Type()[$order_setting_key['setting_key_group']][$order_setting_key['setting_key_type']]}}</td>
                                </tr>
                                <tr id="toggle-orderFinaliseKey-{{$loop->index}}" hidden>
                                    <td colspan="4">
                                        <button type="button" id="delete-orderFinaliseKey-{{$order_setting_key['id']}}" onclick="RemoveSettingKey({{$order_setting_key['id']}})" class="uk-text-danger uk-button uk-width-1-1 uk-button-default uk-border-rounded" uk-icon="trash"></button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                </table>
            @endif --}}
    
            
    
        </div>
        
        
    
        <div class="uk-margin-top-large uk-child-width-1-2@m" uk-grid>
    
            @if (count($data['setupList']['order_setting_key']) > 0)
                <div class="uk-margin-remove-top">KEYS</div>
                <div class="uk-text-right uk-margin-remove-top">{{count($data['setupList']['order_setting_key'])}}</div>
            @endif
    
            
           {{--  @if ($data['setupList']['receipt']['creditTotal'] > 0)
                
                <div class="uk-margin-remove-top">Credit {{$currency}}
                    <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('credit')"></span>
                </div>
                <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($data['setupList']['receipt']['discountTotal'])}}</div>
               
            @endif --}}
    
            {{-- @if ($data['setupList']['receipt']['voucherAmountTotal'] > 0)
                
                <div class="uk-margin-remove-top">Voucher {{$currency}}
                    <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('voucher')"></span>
                </div>
                <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($data['setupList']['receipt']['voucherAmountTotal'])}}</div>
               
            @endif --}}
    
          {{--   @if ($data['setupList']['receipt']['voucherPercentageTotal'] > 0)
                
                <div class="uk-margin-remove-top">Voucher %{{$currency}}
                    <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('voucher')"></span>
                </div>
                <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($data['setupList']['receipt']['voucherPercentageTotal'])}}</div>
               
            @endif --}}
                
            {{-- @if ($data['setupList']['receipt']['discountAmountTotal'] > 0)
                
                <div class="uk-margin-remove-top">Discount{{$currency}}
                    <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('discount')"></span>
                </div>
                <div class="uk-text-right uk-margin-remove-top"> - {{CurrencyHelper::Format($data['setupList']['receipt']['discountAmountTotal'])}}</div>
               
            @endif --}}
    
            {{-- @if ($data['setupList']['receipt']['discountPercentageTotal'] > 0)
                
                <div class="uk-margin-remove-top">Discount %{{$currency}}
                    <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('discount')"></span>
                </div>
                <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($data['setupList']['receipt']['discountPercentageTotal'])}}</div>
            
            @endif --}}
    
           {{--  @if ($data['setupList']['receipt']['deliveryTotal'] > 0)
              
                <div class="uk-margin-remove-top">Delivery {{$currency}}
                    <span class="uk-text-danger" uk-icon="close" onclick="showSetupList('delivery')"></span>
                </div>
                <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($data['setupList']['receipt']['deliveryTotal'])}}</div>
             
            @endif --}}
    
            @isset ($data['setupList']['receipt']['totalSettingVAT'])
              
                <div class="uk-margin-remove-top">VAT % {{MathHelper::FloatRoundUp($data['setupList']['receipt']['totalSettingVAT'], 2)}}</div>
                <div class="uk-text-right uk-margin-remove-top">{{MathHelper::FloatRoundUp($data['setupList']['receipt']['priceVATTotal'] - $data['setupList']['receipt']['subTotal'], 2)}}</div>
                
            @endisset
    
           
            <div class="uk-margin-remove-top">SUB TOTAL {{$currency}}</div>
            <div class="uk-text-right uk-margin-remove-top">{{CurrencyHelper::Format($data['setupList']['receipt']['subTotal'])}}</div>
        
            <div class="uk-margin-remove-top uk-text-bold">TOTAL {{$currency}}</div>
            <div class="uk-text-right uk-margin-remove-top uk-text-bold">{{CurrencyHelper::Format($data['setupList']['receipt']['priceVATTotal'])}}</div>
            
        </div>
      
    </div>
</form>
