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

    <ul class="uk-iconnav uk-margin-small">
        <li><input type="checkbox" class="uk-checkbox" onclick="SelectAll('receiptTableID')"></li>
        <li><button type="button" class="uk-text-danger" onclick="deleteStock(this)" uk-icon="trash" {{$openControlID}}></button></li>
        <li><button uk-icon="tag" type="button" onclick="IndexSetting('stock')"></button></li>
       
    </ul>
    

    <div class="">
       
        
            <div class="uk-overflow-auto uk-height-small uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 25" id="receiptTableID">
        
                <ul class="uk-list uk-list-collapse uk-list-divider" id="cartListID">
                    @isset ($stockList)
                
                        @foreach ($stockList as $stockKey => $stockItem)
                            @php
                                $data['setupList']['stock'] = $stockItem;

                                $data = Receipt::Calculate( $data, $stockItem, $loop );
                                Session::pull('user-session-'.Auth::user()->user_id.'.setupList');
                                Session::put('user-session-'.Auth::user()->user_id.'.setupList', $data['setupList']);
            
                                $cartList = Session::pull('user-session-'.Auth::user()->user_id.'.cartList');
                                /* $cartList[$loop->index]['stock_price'] = $data['setupList']['stock']['stock_price_offer']; */
                                Session::put('user-session-'.Auth::user()->user_id.'.cartList', $cartList);

                                $gain_points = collect($stockItem['stock_setting_offer'])->where('gain_points')->sum();
                                $collect_points_value  = collect($stockItem['stock_setting_offer'])->where('gain_points')->sum();
                               
                            @endphp
                            
                                <li id="cartItemID-{{$loop->index}}" {{-- uk-toggle="target: #toggle-stock-{{$loop->index}}" --}}>
            
                                        <span>
                                            <input type="checkbox" name="receipt_stock_id[]" value="{{$stockKey}}" class="uk-checkbox">
                                        </span>
                                        
                                        <span> {{$stockItem['stock_name']}} </span>

                                        <span>

                                            @if ($stockItem['receipt_setting_key'])
                                                @include('home.partial.settingKeyPartial', [ 'setting_key' => $stockItem['receipt_setting_key'] ])
                                            @endif

                                        </span>

                                        @if ($stockItem['stock_quantity'] > 1)
                                            <span class="uk-text-meta uk-text-top"> {{$stockItem['stock_quantity']}}</span>
                                        @endif

                                        <span class="uk-align-right">

                                            @include('home.partial.settingOffer')

                                            
                                            @if ( count($stockItem['stock_vat']) > 0 || count($stockItem['stock_setting_offer']) > 0)
                                                <del>{{ CurrencyHelper::Format( $stockItem['stock_price'] ) }} </del>
                                                <span>{{ CurrencyHelper::Format( $data['setupList']['stock']['stock_price_offer'] )}}</span>
                                            @else
                                                {{ CurrencyHelper::Format( $stockItem['stock_price'] ) }}
                                            @endif
                                        </span>

                                        {{-- @include('receipt.partial.controlPartial',
                                        [
                                            'cartValue' => $loop->index,
                                            'quantity' => $stockItem['stock_quantity']
                                        ]) --}}
                                        
                                </li>
                               
                               
            
                        @endforeach
            
                    @endisset
                </ul>
                
            </div>
       
       
    </div>
  
    <div>
        @if ($gain_points)
            <div class="uk-box-shadow-small uk-padding-small uk-margin">
                <span>You have earned {{$gain_points}} points, total {{$collect_points_value}}</span>
            </div>
        @endif
    </div>

    <div>

            
        <div>
            @if ( $data['setupList']['receipt']['subTotal'] > 0 )
                <span class="uk-text-bold">SUB TOTAL {{$currency}}</span>
                @include('home.partial.settingKeyPartial', [ 'setting_key' => $data['setupList']['order_setting_key'] ])
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
