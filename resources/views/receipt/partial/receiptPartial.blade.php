@php
    use App\Helpers\CurrencyHelper;
    use App\Models\Scheme;
    use App\Models\Plan;

    $schemeModel = NULL;
    $currency = "";
    $priceVAT = "";
@endphp



<div class="uk-margin uk-child-width-1-2" uk-grid>
    <div>Offer(s) : <span id="schemeCountID"></div>
    <div>Discount(s) : <span id="planCountID"></div>
</div>



<div class="uk-margin">
    <table class="uk-table uk-table-small uk-table-divider uk-height-medium">
        <thead>
            <tr>
                <th class="uk-table-expand">Item</th>
                <th class="uk-width-auto">Qty</th>
                <th>{{$currency}}</th>
                <th></th>
                <th class="uk-table-expand"></th>
            </tr>
        </thead>
        <tbody id="cartListID">
            @if ($data['sessionCartList'] && count($data['sessionCartList']) > 0)
                @foreach ($data['sessionCartList'] as $cartItem)
                    @php
                    
                        $price = $cartItem['price'] * $cartItem['quantity'];
                        $totalPrice = $price + $totalPrice;

                        //scheme
                        $schemeProductList = Scheme::Product('schemetable_id', $cartItem['product'])->get();
                        if ($schemeProductList->count() >= 1) {
                            $discount['value'] = '';
                            $discount['symbol'] = '';

                            $schemeModel = $schemeProductList->where('scheme_isMain', 1)->first();
                            if ($schemeModel) {
                                $discount = Plan::CalculatePlanType($schemeModel);
                                $totalPrice = $totalPrice - $discount['value'];
                            }
                        }

                        if ($loop->last && isset($data['calculate_vat'])) {
                            $priceVAT = MathHelper::VAT($data['userModel']->store_vat, $totalPrice);
                        } else {
                            $priceVAT = $totalPrice;
                        }
        
                    @endphp
                        <tr id="cartItemID-{{$loop->iteration}}">
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
                            <td>
                            
                                    @include('partial.controlsPartial',
                                    [
                                        'cartValue' => $loop->iteration,
                                        'quantity' => $cartItem['quantity']
                                    ])
                            
                            </td>
                            <td>
                                {{CurrencyHelper::Format($cartItem['price'])}}
                            </td>
                            <td>
                                <button type="button" id="deleteID-{{$loop->iteration}}" onclick="Delete({{$loop->iteration}})" class="uk-text-danger" uk-icon="trash">
                                </button>
                            </td>
                            <td>
                                <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="GetScheme({{$cartItem['product']}})">
                                    <span uk-icon="icon: star"></span>
                                    <span class="uk-label"> {{$schemeProductList->count()}}</span>
                                </button>
                            </td>
                        </tr>
                @endforeach
                <tr>
                    <td colspan="4" class="uk-text-right">Sub Total {{$currency}} <span class="uk-margin-left" id="totalPriceID">{{CurrencyHelper::Format($totalPrice)}}</span></td>
                </tr>
                <tr>
                    <td colspan="4" class="uk-text-right">VAT % 
                        <span class="uk-margin-left" id="vatID">
                            @if($data['userModel']->store_vat) 
                                {{$data['userModel']->store_vat}}
                            @else
                                N/A
                            @endif
                            
                        </span></td>
                </tr>
                <tr>
                    <td colspan="4" class="uk-text-right">Total {{$currency}} <span class="uk-margin-left" id="totalPriceID">{{CurrencyHelper::Format($priceVAT)}}</span></td>
                </tr>
            @endif 
        </tbody>
        
    </table>

    <div class="uk-margin">
        <button type="submit" form="formReceipt" uk-switcher-item="next" class="uk-margin-medium uk-box-shadow-small uk-text-lead uk-light uk-border-rounded uk-width-expand uk-button uk-button-danger" uk-icon="icon: tag">
            {{$currency}}
            <span class="uk-margin-right" id="receiptButtonID">{{CurrencyHelper::Format($priceVAT)}}</span>
        </button>
    </div>

    {{-- <div> 
        <div class="uk-text-center">
            <img loading="lazy" src="{{asset('/storage/image/paypal.png')}}">
        </div>
    </div>   --}}

</div>
 