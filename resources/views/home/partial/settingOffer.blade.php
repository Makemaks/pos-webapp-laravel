@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
@endphp

<span class="uk-inline">
    <button uk-icon="triangle-down" type="button"></button>
    <div uk-dropdown="mode: click;pos: bottom-left" class="uk-overflow-auto uk-height-medium">
        <ul class="uk-list uk-list-collapse uk-list-divider">
            

            @if ($data['setupList']['receipt']['stock_vat_rate'])
                <li>
                   <span class="uk-text-bold">VAT%</span> {{ MathHelper::FloatRoundUp($data['setupList']['receipt']['stock_vat_rate'], 2)}}
                </li>
            @endif

            @if ($stockItem['stock_setting_offer'])
                <li>
                    <span class="uk-text-bold">OFFER</span> {{ CurrencyHelper::Format( $data['setupList']['receipt']['stock']['stock_setting_offer_total'] )}}
                </li>
            @endif
        </ul>
       
    </div>
</span>