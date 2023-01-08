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
    $disabled = 'disabled';

    if ($route == 'home' || Str::contains($route, 'api')) {
        $array = [
            'name',
            'value',
            'setting_key_group',
            'setting_key_type',
        ];
    }else{
        $disabled = '';
    }
  
    if ( Session::has('user-session-'.Auth::user()->user_id.'.setupList')) {
        $data['setupList'] = Session::get('user-session-'.Auth::user()->user_id.'.setupList');
    }
   
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

   
    if(Session::has('user-session-'.Auth::user()->user_id.'.cartList')){
        $stockList = Session::get('user-session-'.Auth::user()->user_id.'.cartList');
        // /$stockList = Receipt::SessionCartInitialize($data['cartList'], $data['setupList']);
    }
  
@endphp

@include('receipt.partial.receiptMenuPartial')
<form action="" id="cartFormID" method="POST">
    {{-- <span>
        <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" onclick="control(0)" uk-icon="pencil" {{$openControlID}}></button>
        <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" onclick="control(1)" uk-icon="close" id="controlHideID" {{$closeControlID}}></button>
       {{$currencySymbol}}
   </span> --}}

    <ul class="uk-iconnav">
        <li><input type="checkbox" class="uk-checkbox" onclick="SelectAll('receiptTableID')"></li>
        <li><button type="button" class="uk-text-danger" onclick="deleteStock(this)" uk-icon="trash" {{$openControlID}}></button></li>
        <li><button uk-icon="tag" type="button" onclick="IndexSetting('stock')"></button></li>
       
    </ul>
    

    <div class="uk-overflow-auto uk-height-small uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 25">
       
        
            <div class="" id="receiptTableID">
        
                <div id="cartListID">
                    @isset ($stockList)
                
                        @foreach ($stockList as $stockKey => $stockItem)
                            @php
                                $data = Receipt::Calculate( $data, $stockItem, $loop );
                                Session::pull('user-session-'.Auth::user()->user_id.'.setupList');
                                Session::put('user-session-'.Auth::user()->user_id.'.setupList', $data['setupList']);
            
                                $cartList = Session::pull('user-session-'.Auth::user()->user_id.'.cartList');
                                /* $cartList[$loop->index]['stock_price'] = $data['setupList']['receipt']['stock']['stock_price_processed']; */
                                Session::put('user-session-'.Auth::user()->user_id.'.cartList', $cartList);
                                
                            @endphp
                            
                                <div class="uk-box-shadow-small uk-padding-small uk-margin uk-display-block" id="cartItemID-{{$loop->index}}">
            
                                    <div {{-- uk-toggle="target: #toggle-stock-{{$loop->index}}" --}}>
                                        <span>
                                            <input type="checkbox" name="receipt_stock_id[]" value="{{$stockKey}}" class="uk-checkbox">
                                        </span>

                                        {{$stockItem['stock_name']}} 
                                        @if ($stockItem['stock_quantity'] > 1)
                                            <span class="uk-text-meta uk-text-top"> {{$stockItem['stock_quantity']}}</span>
                                        @endif

                                        <span class="uk-align-right">
                                            @if ( count($stockItem['stock_vat']) > 0 || count($stockItem['stock_setting_offer']) > 0)
                                                <del>{{ CurrencyHelper::Format( $stockItem['stock_price'] ) }} </del>
                                                <span>{{ CurrencyHelper::Format( $data['setupList']['receipt']['stock']['stock_price_processed'] )}}</span>
                                            @else
                                                {{ CurrencyHelper::Format( $stockItem['stock_price'] ) }}
                                            @endif
                                        </span>

                                        <span>
                                            @if ($data['setupList']['receipt']['stock_vat_rate'])
                                                %{{ MathHelper::FloatRoundUp($data['setupList']['receipt']['stock_vat_rate'], 2)}}
                                            @endif
                                            
                                            @if ($stockItem['stock_setting_offer'])
                                            | {{ CurrencyHelper::Format( Setting::SettingCurrentOffer($stockItem['stock_setting_offer'], $data['setupList']['receipt']['stock']['stock_price_processed']) )}}
                                            @endif
                                        </span>
                                        
                                    </div>

                                    
                                    <div>
                                        @foreach ($stockItem['receipt_setting_key'] as $receipt_setting_key_key => $receipt_setting_key_item)
                                            @php
                                                $data['settingModel']->setting_key = $receipt_setting_key_item;
                                            @endphp  
                                            @foreach ($receipt_setting_key_item as $key => $setting_key)
                                                <div class="uk-inline">
                                                    <button uk-icon="triangle-up" type="button">{{ $setting_key['value'] }}</button>
                                                    <div uk-dropdown="mode: click; pos: top-left" class="uk-overflow-auto uk-height-large">
                                                        @include('setting.settingKey.partial.tablePartial')
                                                    </div>
                                                </div>
                                            @endforeach

                                        @endforeach
                                    </div>

                                        {{-- @include('receipt.partial.controlPartial',
                                        [
                                            'cartValue' => $loop->index,
                                            'quantity' => $stockItem['stock_quantity']
                                        ]) --}}
                                        
                                </div>
            
                        @endforeach
            
                    @endisset
                </div>
                
            </div>
       
       
    </div>
  

    <div class="uk-margin">
       
        <div>
            @foreach ($data['setupList']['order_setting_key'] as $order_setting_key_key => $order_setting_key_item)
                @php
                    $data['settingModel']->setting_key = $order_setting_key_item;
                @endphp                  
                @foreach ($order_setting_key_item as $key => $setting_key)
                    <div class="uk-inline">
                        <button uk-icon="triangle-up" type="button">{{ $setting_key['value'] }}</button>
                        <div uk-dropdown="mode: click; pos: top-left" class="uk-overflow-auto uk-height-large">
                            @include('setting.settingKey.partial.tablePartial')
                        </div>
                    </div>
                @endforeach
                
            @endforeach
        </div>

            
        <div>
            @if ( $data['setupList']['receipt']['subTotal'] > 0 )
                <span class="uk-text-bold">SUB TOTAL {{$currency}}</span>
                <span>{{CurrencyHelper::Format($data['setupList']['receipt']['subTotal'])}}</span>
            @endif
        </div>

        <div>
            @if ( $data['setupList']['receipt']['subTotal'] > 0)
                <span class="uk-text-bold">VAT %</span>
                <span uk-icon="triangle-right"></span> {{ MathHelper::FloatRoundUp( collect($data['settingModel']->setting_vat)->where('default', 0)->sum('rate'), 2 ) }} 
                <span uk-icon="triangle-up"></span> {{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock_vat_total_rate'], 2 ) }}
                
                <span uk-icon="arrow-right"></span>
                <span>
                    {{ MathHelper::FloatRoundUp($data['setupList']['receipt']['order_vat_total_amount'], 2) }} |
                    {{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock_vat_total_amount'], 2 ) }}
                </span>
                
            @endif
        </div>

        <div>
            @if ( $data['setupList']['receipt']['priceTotal'] > 0 )
                <span class="uk-text-bold">TOTAL {{$currency}}</span>
                <span>{{CurrencyHelper::Format($data['setupList']['receipt']['priceTotal'])}}</span>
            @endif
           
        </div>

          

    </div>
</form>
