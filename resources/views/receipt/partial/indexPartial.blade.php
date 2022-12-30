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
        $data['setupList'] = Session::get('user-session-'.Auth::user()->user_id.'.'.'setupList');
    }
   
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

   
    if(Session::has('user-session-'.Auth::user()->user_id.'.'.'cartList') && isset($stockList) == false){
       
        $data['cartList'] = Session::get('user-session-'.Auth::user()->user_id.'.'.'cartList');
        
        $stockList = Receipt::SessionCartInitialize($data['cartList']);
    }
  
@endphp

@include('receipt.partial.receiptMenuPartial')
<form action="" id="cartFormID" method="POST">
  
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="home" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="list" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="tag" class="uk-border-rounded"></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
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
        </li>
        <li class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
            @include('receipt.partial.listPartial')
            
           {{--  <div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
                <table class="uk-table uk-table-small">
                
                    <tbody>
                    
                        @if (count($data['setupList']['order_setting_key']) > 0)
                            @foreach ($data['setupList']['order_setting_key'] as $order_setting_key_list)
                                <tr>
                                    @foreach ($order_setting_key_list as $order_setting_key)
                                        <td>
                                            {{ $order_setting_key['name'] }} @ {{ Setting::SettingKeyGroup()[ $order_setting_key['setting_key_group'] ]}} ~ {{ KeyHelper::Type()[$order_setting_key['setting_key_group']][ $order_setting_key['setting_key_type']]  }}
                                        </td> 
                                        <td>
                                            {{$order_setting_key['value']}}
                                        </td> 
                                    @break
                                    @endforeach
                                </tr>
                            @endforeach
                        @endif

                    </tbody>
                </table>
        
            </div> --}}
        </li>
        <li class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
            @include('setting.settingKey.index')
        </li>
    </ul>

    <div class="uk-margin uk-overflow-auto uk-height-small">
        <table class="uk-table uk-table-small">
        
            <tbody>
            
                <tr>
                    @isset ($data['setupList']['receipt']['settingVATTotal'])
                        <td>VAT % {{MathHelper::FloatRoundUp($data['setupList']['receipt']['settingVATTotal'], 2)}}</td>
                        <td>{{MathHelper::FloatRoundUp($data['setupList']['receipt']['priceVATTotal'] - $data['setupList']['receipt']['subTotal'], 2)}}</td>
                    @endisset
                </tr>

                <tr>
                    <td>SUB TOTAL {{$currency}}</td>
                    <td>{{CurrencyHelper::Format($data['setupList']['receipt']['subTotal'])}}</td>
                </tr>

                <tr>
                    <td>TOTAL {{$currency}}</td>
                    <td>{{CurrencyHelper::Format($data['setupList']['receipt']['priceVATTotal'])}}</td>
                </tr>

            </tbody>
        </table>

    </div>


</form>
