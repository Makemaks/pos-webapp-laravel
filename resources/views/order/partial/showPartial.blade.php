@php
    use App\Models\User;
    use App\Models\Order;
    use App\Models\Stock;
    use App\Models\Receipt;
    use App\Helpers\MathHelper;
    use App\Helpers\CountryHelper;

    

    $default_currency = $data['settingModel']->setting_group['default_country'];
   
    $currency = CountryHelper::ISO()[$default_currency]['currencies'][0];
    $orderTotal = 0;

 
    $stockList = Receipt::ReceiptDisplay( $data['orderList'] );
@endphp

@include('receipt.partial.indexPartial', [ 'stockList' => $stockList])




{{-- @php
   
    $order_setting_vat = array_sum($orderList->pluck('order_setting_vat')->toArray());
    $priceVAT = MathHelper::VAT($order_setting_vat, $orderTotal);
@endphp
<div class="uk-margin-medium uk-box-shadow-small uk-text-lead uk-light uk-border-rounded uk-width-expand uk-button uk-button-default" uk-icon="icon: tag">
    {{$currency}}
    <span class="uk-margin-right" id="receiptButtonID">{{MathHelper::FloatRoundUp($priceVAT, 2)}}</span>
</div> --}}