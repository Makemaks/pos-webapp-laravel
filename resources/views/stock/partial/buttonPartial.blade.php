@php
    use App\Models\Warehouse;
    use App\Helpers\MathHelper;
@endphp

<div class="uk-inline">
    <button uk-icon="icon: triangle-down" type="button"><b>{{Str::ucfirst($stock->stock_merchandise['stock_name'])}}</b></button>
    <div uk-dropdown="mode: click; pos: bottom-center">
        <div>
            {{-- <div class="uk-width-auto" title="{{$stock->stock_id}}">
                <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
            </div> --}}

            <b>Overview</b>
        
            <div class="uk-child-width-1-2" uk-grid>
                @php
                    $warehouseStockList = Warehouse::WarehouseExplore($stock->stock_id, $storeID);
                @endphp
                <div>Qty</div>
                @if($warehouseStockList->count() > 0) 
                    <div>{{$warehouseStockList->sum('warehouse_quantity')}}</div>
                @endif
            </div>
            
            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                <div>VAT</div>
                <div class="uk-text-small">
                    @if ($stock->stock_merchandise['stock_vat_id'] == 'null')
                        @foreach ($data['settingModel']->setting_vat as $item)
                            @if ($item['default'] == 0)
                                {{ MathHelper::FloatRoundUp($item['rate'], 2) }}
                            @endif
                        @endforeach
                    @else
                        @if (array_key_exists( $stock->stock_merchandise['stock_vat_id'], $data['settingModel']->setting_vat) )
                            {{ MathHelper::FloatRoundUp($data['settingModel']->setting_vat[ $stock->stock_merchandise['stock_vat_id'] ]['rate'], 2) }}
                        @endif
                    @endif    
                </div>
            </div>
        
            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                <div>Price</div>
                @if (count($stockPriceFinalize) > 0)
                    <div>{{ MathHelper::FloatRoundUp( $stockPriceFinalize['stock_offer_processed']['stock_price'], 2) }}</div>
                @endif
            </div>
           
            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                <div>Offer</div>
                @if ( array_key_exists('decimal', $stockPriceFinalize) )
                    <div>
                        @if ($stockPriceFinalize['decimal']['discount_type'] == 0)
                            %
                        @endif
                        {{ MathHelper::FloatRoundUp( $stockPriceFinalize['decimal']['discount_value'], 2) }}
                    </div>
                @endif
            </div>
            
        </div>
    </div>
</div>


