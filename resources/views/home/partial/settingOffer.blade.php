@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Models\Setting;

    
    $stock_vat_total = MathHelper::VAT(collect($data['setupList']['stock']['stock_vat'])->sum('rate'), $data['setupList']['stock']['stock_price_offer'] );
    $stock_vat_total = MathHelper::FloatRoundUp($stock_vat_total, 2);
    $stock_price_processed = $data['setupList']['stock']['stock_price_offer'] + $stock_vat_total;
@endphp

<span class="uk-inline">
    <button uk-icon="triangle-down" type="button"></button>
    <div uk-dropdown="mode: click;pos: bottom-right" class="uk-overflow-auto uk-height-large">
       
        <div class="uk-width-auto">
            <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
        </div>

        <div class="uk-margin-small">
            <b>OVERVIEW</b>
            <div class="uk-margin-remove-top">{{$data['setupList']['stock']['stock_name']}}</div>
        </div>
       
        <div class="uk-margin-small">
            <b>Price{{Setting::SettingCurrency($data)}}</b>
            <div>
                @if ($data['setupList']['stock']['stock_price_offer'] != $data['setupList']['stock']['stock_price_offer'])
                    <del>
                        {{ MathHelper::FloatRoundUp( $data['setupList']['stock']['stock_price'], 2) }}
                    </del>
                @else
                    {{ MathHelper::FloatRoundUp( $data['setupList']['stock']['stock_price'], 2) }}
                @endif
            </div>
        </div>


        <div class="uk-margin-small">
            <b>OFFER</b>
            @foreach ($data['setupList']['stock']['stock_setting_offer'] as $item)
                <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                    <div>{{Setting::SettingSettingOfferType()[ $item['decimal']['discount_type'] ]}}</div>
                    <div>{{ MathHelper::FloatRoundUp( $item['decimal']['discount_value'], 2) }}</div>
                </div>
            @endforeach

            
            @if ($data['setupList']['stock']['stock_price_offer'])
                <div class="uk-child-width-1-2  uk-margin-remove-top" uk-grid>
                    <div>Total{{Setting::SettingCurrency($data)}}</div>
                    <div>{{ CurrencyHelper::Format( $data['setupList']['stock']['stock_price_offer'] )}}</div>
               </div>
            @endif
        </div>

        <div class="uk-margin-small">
            <b>VAT%</b>
            
            @foreach ($data['setupList']['stock']['stock_vat'] as $item)
                <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                    <div>{{$item['name']}}</div>
                    <div>{{ MathHelper::FloatRoundUp($item['rate'], 2) }}</div>
                </div>
            @endforeach

            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                <div>Total{{Setting::SettingCurrency($data)}}</div>
                <div>{{ $stock_vat_total }}</div>
            </div>

        </div>

        <div class="uk-margin-small">
            <b>Total{{Setting::SettingCurrency($data)}}</b>

            <div class="uk-child-width-1-2" uk-grid>
                <div>  @ {{MathHelper::FloatRoundUp( $data['setupList']['stock']['stock_price_offer'], 2)}}</div>
                <div>{{ MathHelper::FloatRoundUp( $stock_price_processed, 2) }}</div>
            </div>
        </div>
       
    </div>
</span>