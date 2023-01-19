@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Models\Setting;

@endphp

<span class="uk-inline">
    <button uk-icon="triangle-down" type="button"></button>
    <div uk-dropdown="mode: click;pos: bottom-right" class="uk-overflow-auto uk-height-large">
       
        <div class="uk-margin-small">
            <b>PRICE</b>
            <div class="uk-grid-collapse" uk-grid>
                <div><h3 class="uk-margin-remove-top">{{Setting::SettingCurrency($data)}}{{ MathHelper::FloatRoundUp( $data['setupList']['stock_price_total'], 2) }}</h3></div>
                <div>
                    @if (count( $data['setupList']['stock_setting_offer'] ) > 0 || count( $data['setupList']['stock_setting_vat'] ) > 0)
                        <del>
                            {{ MathHelper::FloatRoundUp( $data['setupList']['stock_price'], 2) }}
                        </del>
                    @else
                        {{ MathHelper::FloatRoundUp( $data['setupList']['stock_price'], 2) }}
                    @endif
                </div>
            </div>
            
        </div>

        <ul class="uk-margin-small uk-padding-remove" uk-accordion>

            <li>
                <a class="uk-accordion-title" href="#">
                    <span>
                        {{$stockItem['store_name']}}
                    </span>
                </a>
               
                <div class="uk-accordion-content">
                    <div class="uk-width-auto">
                        <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
                    </div>
                    
                    <div class="uk-margin-small">
                        <b>OVERVIEW</b>
                        <div class="uk-margin-remove-top">{{$stockItem['stock_name']}}</div>
                    </div>
                </div>
               
            </li>

            <li>
                <a class="uk-accordion-title" href="#">
                    <span>
                        OFFER
                        @if ($data['setupList']['stock_setting_offer_total'])
                            <span class="uk-text-small uk-text-top">{{Setting::SettingCurrency($data)}}{{ CurrencyHelper::Format( $data['setupList']['stock_setting_offer_total'] )}}</span>
                        @endif 
                    </span>
                </a>
               
                <div class="uk-accordion-content">
                    <div>
                        @foreach ($data['setupList']['stock_setting_offer'] as $item)
                            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                                
                                <div>{{Setting::SettingSettingOfferType()[ $item['decimal']['discount_type'] ]}}</div>
                                <div>{{ MathHelper::FloatRoundUp( $item['decimal']['discount_value'], 2) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
               
            </li>
            <li>
                <a class="uk-accordion-title" href="#">
                    <span>
                        VAT%
                        @if ($data['setupList']['stock_vat_amount_total'])
                            <span class="uk-text-small uk-text-top">{{Setting::SettingCurrency($data)}}{{ MathHelper::FloatRoundUp( $data['setupList']['stock_vat_amount_total'], 2)  }}</span>
                        @endif 
                    </span>
                </a>
                <div class="uk-accordion-content">
                    <div>
                        
                        @foreach ($data['setupList']['stock_setting_vat'] as $item)
                            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                                <div>{{$item['name']}}</div>
                                <div>{{ MathHelper::FloatRoundUp($item['rate'], 2) }}</div>
                            </div>
                        @endforeach
                        
                    </div>
                </div>
            </li>

            <li>
                <a class="uk-accordion-title" href="#">
                    <span>
                        KEY
                        <span class="uk-text-small uk-text-top">
                            {{$data['setupList']['setting_key_amount_total']}}
                        </span>
                    </span>
                </a>
                <div class="uk-accordion-content">
                    @if ( count(  $data['setupList']['stock_setting_key'] ) > 0 && $data['setupList']['setting_key_amount_total'] )
                        
                        @include('home.partial.settingKeyPartial')

                    @endif
                </div>
            </li>
        </ul>

        <div class="uk-grid-small uk-margin-small" uk-grid>
            <div><b>TOTAL</b></div>
            <div>{{Setting::SettingCurrency($data)}}{{MathHelper::FloatRoundUp( $data['setupList']['stock_price_processed'], 2)}}</div>
        </div>

     
       
    </div>
</span>