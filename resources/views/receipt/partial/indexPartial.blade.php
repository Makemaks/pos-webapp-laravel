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
    
    $schemeModel = NULL;
    $currency = "";
    $priceVAT = 0;
    $totalPrice = 0;
    $stock_vat = 0;
    

    $data['sessionCartList'] = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

    if(Session::has('user-session-'.Auth::user()->user_id. '.cartList')){
       
        $data['sessionCartList'] = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
        
        foreach ($data['sessionCartList'] as $sessionCartList) {

            $stock = Stock::find($sessionCartList['stock_id']);

            $cost = Stock::StockCostDefault($stock->stock_cost);
            $stock_vat = Stock::StockVAT($stock);
            
            $stockList[] = [
                'stock_id' => $stock->stock_id,
                'stock_name' => $stock->stock_merchandise['stock_name'],
                'stock_quantity' => $sessionCartList['stock_quantity'],
                'stock_cost' => MathHelper::FloatRoundUp($cost, 2),
                'stock_vat_id' => $stock->stock_merchandise['stock_vat_id']
            ];
        } 
      
    }

  
@endphp


<div class="uk-height-large uk-overflow-auto">
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody id="cartListID">
            @isset ($stockList)
                @foreach ($stockList as $stockKey => $stockItem)
                    @php
                    
                        //convert sting to val
                        $price = $stockItem['stock_cost'] * intval($stockItem['stock_quantity']);
                        $stock_vat_rate = null;

                        if ($stockItem['stock_vat_id']) {
                            $stock_vat_rate = $data['settingModel']->setting_vat[$stockItem['stock_vat_id']]['rate'];
                            $priceVAT = $priceVAT + MathHelper::VAT($stock_vat_rate, $price);
                            $totalPrice = $price + $totalPrice;
                        } else {
                            $totalPrice = $price + $totalPrice;
                        }
                        

                    @endphp
                        <tr id="cartItemID-{{$loop->index}}">
                            <td>
                                
                                {{$stockItem['stock_name']}} 
                                @if ($stockItem['stock_quantity'] > 1)
                                    <span class="uk-text-meta uk-text-top"> {{$stockItem['stock_quantity']}}</span>
                                @endif
                            
                                @include('partial.controlPartial',
                                [
                                    'cartValue' => $loop->index,
                                    'quantity' => $stockItem['stock_quantity']
                                ])
                            </td>

                            <td>
                              
                                @if ($stock_vat_rate)
                                    {{ MathHelper::FloatRoundUp($stock_vat_rate, 2)}}
                                @endif
                                

                            </td>

                            <td>
                                {{CurrencyHelper::Format($stockItem['stock_cost'])}}
                            </td>
                           
                        </tr>
                      
                @endforeach

            @endisset
        </tbody>
        
    </table>
</div>


<div class="uk-margin-large">
    <div class="uk-margin-large">
        <div class="uk-text-right">Sub Total {{$currency}} 
            <span class="uk-margin-left" id="totalPriceID">{{CurrencyHelper::Format($totalPrice)}}</span>
        </div>
        <div class="uk-text-right">VAT % 
            <span class="uk-margin-left" id="vatID">
                @if($data['userModel']->store_vat) 
                    {{$data['userModel']->store_vat}}
                @else
                    N/A
                @endif
                    
            </span>
        </div>
        <div class="uk-text-right">Total {{$currency}} 
            <span class="uk-margin-left" id="totalPriceID">{{CurrencyHelper::Format($priceVAT + $totalPrice)}}</span>
        </div>
    </div>
    
    <div>
        
      

        @if (Person::PersonType()[$data['userModel']->person_type] == 'Customer')
            <div class="uk-height-small uk-background-muted uk-border-rounded uk-padding  uk-box-shadow-small" onclick="PaymentType(1, {{$priceVAT}})">
                Pay
            </div>
        @else
           
        <form id="receipt-store" action="{{route('receipt.store')}}"  method="POST">

        </form> 

            <div class="uk-child-width-expand@s uk-text-center uk-grid-small uk-button" uk-grid>
               
                <div>
                    <div type="submit" form="receipt-store" value="order_type[]">
                        <div class="uk-height-small uk-background-muted uk-border-rounded uk-padding uk-box-shadow-small">
                            CASH
                        </div>
                    </div>
                </div>
                
               <div>
                    <div onclick="document.getElementById('receipt-store').submit();">
                        <div class="uk-height-small uk-background-muted uk-border-rounded uk-padding uk-box-shadow-small">
                            TERMINAL
                        </div>
                    </div>
               </div>

            </div>

        @endif

    </div>
</div>

{{-- 
<div class="uk-margin-large">

    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
      
    </ul>
    
    <ul class="uk-switcher">
        <li>
            
           
    
        </li>
    
        <li>
            <div id="paymentID">

            </div>
        </li>
    
        <li>
           
        </li>

        <li>
            <div>
                <div id="customerID">
                     @include('partial.numpadPartial', ['type' => 0])
                    @include('receipt.partial.personPartial')
                </div>
            </div>
        </li>
        
    </ul>
    
    

</div> --}}