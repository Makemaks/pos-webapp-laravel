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
        // /$stockList = Receipt::SessionCartInitialize($data['cartList'], $data);
    }

    $gain_points = 0;
    $collect_points_value = 0;
  
@endphp

@include('receipt.partial.receiptMenuPartial')
<form action="" id="cartFormID" method="POST">
    {{-- <span>
        <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" onclick="control(0)" uk-icon="pencil" {{$openControlID}}></button>
        <button type="button" class="uk-button uk-button-default uk-border-rounded uk-button-small" onclick="control(1)" uk-icon="close" id="controlHideID" {{$closeControlID}}></button>
       {{$currencySymbol}}
   </span> --}}

    <div class="uk-grid-small uk-margin-bottom" uk-grid>
        <div><button type="button" class="uk-border-rounded uk-button uk-button-default uk-button-small" uk-icon="check" onclick="SelectAll('cartListID')"></button></div>
        <div><button type="button" class="uk-border-rounded uk-button uk-button-default uk-button-small"  uk-icon="trash" onclick="deleteStock(this)" uk-icon="trash" {{$openControlID}}></button></div>
    </div>
    
    <div class="">
       
            <div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 25">
        
                <ul class="uk-list uk-list-collapse uk-list-divider" id="cartListID">
                    @isset ($stockList)
                
                        @foreach ($stockList as $stockKey => $stockInitialize)
                            @php

                                $data = Stock::StockPriceProcessed($stockInitialize, $data, $loop);

                                $data = Receipt::Calculate( $data, $stockInitialize, $loop );
                                $setupList = Session::pull('user-session-'.Auth::user()->user_id.'.setupList');
                                Session::put('user-session-'.Auth::user()->user_id.'.setupList', $data['setupList']);
            
                                $cartList = Session::pull('user-session-'.Auth::user()->user_id.'.cartList');
                                /* $cartList[$loop->index]['stock_price'] = $data['setupList']['stock_price_total']; */
                                Session::put('user-session-'.Auth::user()->user_id.'.cartList', $cartList);

                                $gain_points = collect($stockInitialize['stock_setting_offer'])->where('gain_points')->sum();
                                $collect_points_value  = collect($stockInitialize['stock_setting_offer'])->where('gain_points')->sum();

                            @endphp
                            
                                <li id="cartItemID-{{$loop->index}}" {{-- uk-toggle="target: #toggle-stock-{{$loop->index}}" --}}>
            
                                        <span>
                                            <input type="checkbox" name="receipt_stock_id[]" value="{{$stockKey}}" class="uk-checkbox">
                                        </span>
                                        
                                        <span> {{$stockInitialize['stock_name']}} </span>

            
                                        @if ($stockInitialize['stock_quantity'] > 1)
                                            <span class="uk-text-meta uk-text-top"> {{$stockInitialize['stock_quantity']}}</span>
                                        @endif

                                        <span class="uk-align-right">

                                            @include('home.stock.dropdown')
                                            
                                            @if ( count($stockInitialize['stock_setting_vat']) > 0 || count($stockInitialize['stock_setting_offer']) > 0)
                                                <del>{{ CurrencyHelper::Format( $data['setupList']['stock_price'] ) }} </del>
                                                
                                            @endif

                                          
                                            <span>{{MathHelper::FloatRoundUp( $data['setupList']['stock_price_total'], 2)}}</span>
                                           
                                            
                                        </span>

                                        {{-- @include('receipt.partial.controlPartial',
                                        [
                                            'cartValue' => $loop->index,
                                            'quantity' => $stockInitialize['stock_quantity']
                                        ]) --}}
                                        
                                </li>
                               
                        @endforeach
            
                    @endisset
                </ul>
                
            </div>
    </div>
  
    

   <div>
       
        <ul class="uk-list uk-list-collapse">

            <li>
                @if ($gain_points)
                    <div class="uk-box-shadow-small uk-padding-small uk-margin">
                        <span>You have earned {{$gain_points}} points, total {{$collect_points_value}}</span>
                    </div>
                @endif
            </li>

            <li>
                @if ( count( $data['setupList']['order_setting_key']) > 0 && $data['setupList']['setting_key_amount_total'])
                   
                    <span class="uk-text-bold">
                        KEY {{$currency}}
                    </span>
                    <span>
                        <div class="uk-inline">
                            <button uk-icon="triangle-right" type="button"></button>
                            <div class="uk-overflow-auto uk-height-medium" uk-dropdown="mode: click; pos: right-top">

                                @include('home.partial.settingKeyPartial')
                               
                            </div>
                        </div>
                    </span>
                    <span class="uk-align-right">
                        {{$data['setupList']['order_setting_key_total']}}
                    </span>
                @endif
               
            </li>

            <li>
                @if ( $data['setupList']['order_sub_total'] > 0 )
                    <span class="uk-text-bold">SUB TOTAL {{$currency}}</span>
                    <span class="uk-align-right">{{CurrencyHelper::Format($data['setupList']['order_sub_total'])}}</span>
                @endif
            </li>

            <li>
                @if ( $data['setupList']['order_sub_total'] > 0)

                    <span class="uk-text-bold">VAT %</span>
                    <span uk-icon="triangle-right"></span> {{ MathHelper::FloatRoundUp( collect($data['settingModel']->setting_vat)->where('default', 0)->sum('rate'), 2 ) }} 
                    <span uk-icon="triangle-up"></span> {{ MathHelper::FloatRoundUp( $data['setupList']['stock_vat_rate_total'], 2 ) }}
                    
                    <span class="uk-align-right">
                        <span uk-icon="triangle-right"></span>{{ MathHelper::FloatRoundUp( $data['setupList']['order_vat_amount_total'], 2) }}
                        <span uk-icon="triangle-up"></span>{{ MathHelper::FloatRoundUp( $data['setupList']['stock_vat_amount_total'], 2 ) }}
                    </span>
                    
                @endif
            </li>

            <li>
                @if ( $data['setupList']['order_price_total'] >= 0 )
                    <span class="uk-text-bold">TOTAL {{$currency}}</span>
                    <span class="uk-align-right uk-text-bold">{{CurrencyHelper::Format( $data['setupList']['order_price_total'])}}</span>
                @else
                    <h3>Negative</h3>
                @endif
            
            </li>

        </ul>
   </div>

</form>
