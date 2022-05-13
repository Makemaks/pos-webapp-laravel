@php
    use App\Models\User;
    use App\Helpers\MathHelper;
    use App\Helpers\CurrencyHelper;

    $currency = CurrencyHelper::Currency();
    $totalPrice = 0;
@endphp

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th class="uk-table-expand">Item</th>
            <th class="uk-text-right">Price</th>
        </tr>
    </thead>
    <tbody id="cartListID">
        @foreach ($data['orderList'] as $order)
            @php
                $totalPrice = $order->sum('product_cost_price') + $totalPrice;
            @endphp
                <tr>
                    <td>
                        {{$order->first()->product_name}}
                    </td>
                    <td class="uk-text-right">{{$currency}} {{CurrencyHelper::Format($order->first()->product_cost_price)}}</td>
                </tr>
        @endforeach
            <tr>
                <td class="uk-text-right">VAT</td>
                <td class="uk-text-right">% {{$data['userModel']->setting_vat}}</td>
            </tr>
            <tr>
                <td class="uk-text-right">Total</td>
                <td class="uk-text-right">{{$currency}} {{CurrencyHelper::Format($totalPrice)}}</td>
            </tr>
    </tbody>
</table>
@php
    $priceVAT = MathHelper::VAT($data['settingModel']->setting_vat, $totalPrice);
@endphp
<div class="uk-margin-medium uk-box-shadow-small uk-text-lead uk-light uk-border-rounded uk-width-expand uk-button uk-button-danger" uk-icon="icon: tag">
    {{$currency}}
    <span class="uk-margin-right" id="receiptButtonID">{{CurrencyHelper::Format($priceVAT)}}</span>
</div>