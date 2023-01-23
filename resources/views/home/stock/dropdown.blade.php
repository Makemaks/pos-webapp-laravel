@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Models\Setting;

@endphp

<span class="uk-inline">
    <button uk-icon="triangle-down" type="button"></button>
    <div uk-dropdown="mode: click;pos: bottom-right" class="uk-overflow-auto uk-height-large">
       
        <ul class="uk-subnav uk-subnav-pill uk-margin-remove uk-padding-remove" uk-switcher>
            <li><a href="#" uk-icon="home"></a></li>
            <li><a href="#" uk-icon="database"></a></li>
        </ul>
        
        <ul class="uk-switcher uk-margin uk-padding-remove">
            <li>@include('home.stock.menu')</li>
            <li>
                @isset($data['warehouseStoreList'])
                    <ul class="uk-list uk-list-collapse uk-list-divider">
                        @foreach ($data['warehouseStoreList'] as $warehouseStoreKey => $warehouseStore)
                        
                            <li>
                                <span>
                                    <button onclick="Add('{{$stockItem->stock_id}}', '{{$warehouseStore->first()->warehouse_store_id}}')" title="{{$stockItem->stock_id}}" class="uk-button uk-button-default uk-border-rounded uk-button-small" type="button">
                                        <span uk-icon="icon: cart"></span>
                                    </button>
                                </span>
                                {{$warehouseStore->first()->store_name}} - {{$warehouseStore->sum('warehouse_stock_quantity')}}

                            </li>
                        @endforeach
                    </ul>
                @endisset
            </li>
        </ul>

    </div>
</span>