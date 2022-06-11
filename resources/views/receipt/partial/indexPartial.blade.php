@push('scripts')
    <script src="{{ asset('js/gateway.js') }}"></script>
@endpush

@php
    
    use App\Helpers\CurrencyHelper;
    use App\Models\Scheme;
    use App\Models\Plan;
    use App\Models\Stock;
    use App\Models\User;
    
    $schemeModel = NULL;
    $currency = "";
    $priceVAT = 0;
    $totalPrice = 0;

    $data['sessionCartList'] = Session::get('user-session-'.Auth::user()->user_id. '.cartList');
    $data['userModel'] = User::Account('user_account_id', Auth::user()->user_account_id)
    ->first();

@endphp

<div>

    <div>
        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th class="uk-table-expand">Item</th>
                    {{-- <th class="uk-width-auto">Qty</th> --}}
                    <th>{{$currency}}</th>
                    {{-- <th></th> --}}
                    <th></th>
                </tr>
            </thead>
            <tbody id="cartListID">
                @if ($data['sessionCartList'] && count($data['sessionCartList']) > 0)
                    @foreach ($data['sessionCartList'] as $cartKey => $cartItem)
                        @php
                        
                            $price = $cartItem['price'] * $cartItem['quantity'];
                            $totalPrice = $price + $totalPrice;
    
                            //scheme
                        /*  $schemeProductList = Scheme::Product('schemetable_id', $cartItem['product_id'])->get();
                            if ($schemeProductList->count() >= 1) {
                                $discount['value'] = '';
                                $discount['symbol'] = '';
    
                                $schemeModel = $schemeProductList->where('scheme_isMain', 1)->first();
                                if ($schemeModel) {
                                    $discount = Plan::CalculatePlanType($schemeModel);
                                    $totalPrice = $totalPrice - $discount['value'];
                                }
                            } */
    
                            if ($loop->last && isset($data['calculate_vat'])) {
                                $priceVAT = MathHelper::VAT($data['userModel']->store_vat, $totalPrice);
                            } else {
                                $priceVAT = $totalPrice;
                            }
            
                        @endphp
                            <tr id="cartItemID-{{$cartKey}}">
                                <td>
                                    
                                    {{$cartItem['name']}}
                                    <p class="uk-text-meta uk-margin-remove-top">
                                    
                                    {{-- @include('plan.partial.listPartial') --}}
                                    @if ($schemeModel)
                                            <span class="uk-text-danger">*</span> 
                                            {{$discount['symbol']}}{{CurrencyHelper::Format($discount['value'])}}
                                    @endif
                                    </p>
                                </td>
                                {{-- <td>
                                
                                        @include('partial.controlsPartial',
                                        [
                                            'cartValue' => $cartKey,
                                            'quantity' => $cartItem['quantity']
                                        ])
                                
                                </td> --}}
                                <td>
                                    {{CurrencyHelper::Format($cartItem['price'])}}
                                </td>
                                <td>
                                    <button type="button" id="deleteID-{{$cartKey}}" onclick="Delete({{$cartKey}})" class="uk-text-danger" uk-icon="trash">
                                    </button>
                                </td>
                                {{-- <td>
                                    <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="GetScheme({{$cartItem['product_id']}})">
                                        <span uk-icon="icon: star"></span>
                                    <span class="uk-label"> {{$schemeProductList->count()}}</span>
                                    </button>
                                </td> --}}
                            </tr>
                    @endforeach
    
                @endif 
            </tbody>
            
        </table>
    </div>
    
    <div class="uk-margin-medium" uk-grid>

        <div class="uk-width-expand">
            <div class="uk-margin">
                <label><input class="uk-radio" type="radio" name="radio2" checked> CASH</label>
            </div>
        
            <div class="uk-margin-medium">
                <label><input class="uk-radio" type="radio" name="radio2" onclick="PaymentType(1, {{$priceVAT}})"> CARD</label>
            </div>
        </div>
        
        
        <div>
           
            <div>
                <div class="uk-text-right uk-text-lead">Sub Total {{$currency}} 
                    <span class="uk-margin-left" id="totalPriceID">{{CurrencyHelper::Format($totalPrice)}}</span>
                </div>
            </div>
            <div>
                <div class="uk-text-right uk-text-lead">VAT % 
                    <span class="uk-margin-left" id="vatID">
                        @if($data['userModel']->store_vat) 
                            {{$data['userModel']->store_vat}}
                        @else
                            N/A
                        @endif
                        
                    </span>
                </div>
            </div>
            <div>
                <div class="uk-text-right uk-text-lead">Total {{$currency}} 
                    <span class="uk-margin-left" id="totalPriceID">{{CurrencyHelper::Format($priceVAT)}}</span>
                </div>
            </div>

        </div>
    </div>
     
</div>

<div class="uk-margin" id="payment">

</div>
