@php
   use App\Helpers\CurrencyHelper;
    use App\Helpers\CountryHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    
    use App\Models\User;
    use App\Models\Stock;
    use App\Models\Store;
    use App\Models\Setting;
    use App\Models\Warehouse;

    $route = Str::before(Request::route()->getName(), '.');
    
@endphp

@push('scripts')
    <script src="{{ asset('js/stock.js') }}"></script>
@endpush

@include('stock.partial.groupPartial')
   
<form action="" id="stockFormID" method="POST">
    <div>
        
        <div class="uk-grid-match uk-child-width-1-3@s uk-grid-small uk-text-small" uk-grid>
        
            <div>
                <div class="uk-padding-small uk-box-shadow-small">
    
                    <div class="uk-margin">
                        <select name="stock_group" id="stockGroupTypeID" class="uk-select">
                            <option disabled selected>FILTER... </option>
                            @foreach (Setting::SettingStockGroup() as $setting_stock_group)
                                <option onclick="stockGroup({{$loop->iteration}}, '{{$setting_stock_group}}', null)">{{Str::upper($setting_stock_group)}}</option>
                            @endforeach
                        </select>
                    </div>
    
                    <div class="uk-margin">
                        <div class="uk-search uk-search-default">
                            <span class="uk-search-icon-flip" uk-search-icon></span>
                            <input class="uk-search-input uk-width-expand" type="search" placeholder="Search" aria-label="Search">
                        </div>
                        
                    </div>
    
                </div>
            </div>
    
            <div>
                <div class="uk-padding-small uk-box-shadow-small">
                   
                    <div class="uk-margin">
                        <select name="setting_stock_price_group" class="uk-select">
                            <option disabled selected>PRICE GROUP...</option>
                            @for ($i = 1; $i < $data['settingModel']->setting_stock_price_group + 1; $i++)
                                <option value="{{$i}}" @if ($data['setupList']['requestInput']['setting_stock_price_group'] == $i) selected @endif>GROUP {{$i}}</option>
                            @endfor
                        </select>
                    </div>
    
                    <div class="uk-margin">
                        <select name="setting_stock_price_level" class="uk-select" onchange="IndexStock()">
                            <option disabled selected>PRICE LEVEL...</option>
                            @foreach ($data['settingModel']->setting_stock_price_level as $setting_stock_price_level)
                                <option value="{{$loop->iteration}}" @if ($data['setupList']['requestInput']['setting_stock_price_level'] == $loop->iteration) selected @endif>{{Str::upper($setting_stock_price_level['name'])}}</option>
                            @endforeach
                        </select>
                    </div>
    
                </div>
            </div>
    
            <div>
                <div class="uk-padding-small uk-box-shadow-small">
                   
                    <div class="uk-margin">
                        <select name="" class="uk-select">
                            <option disabled selected>PRICE GROUP...</option>
                            @for ($i = 0; $i < $data['settingModel']->setting_stock_price_group; $i++)
                                <option @if($i == 0) selected @endif>GROUP {{$i}}</option>
                            @endfor
                        </select>
                    </div>
    
                    <div class="uk-margin">
                        <select name="" class="uk-select">
                            <option disabled selected>PRICE LEVEL...</option>
                           {{--  @foreach ($data['settingModel']->setting_stock_price as $setting_stock_price)
                                <option  onclick="settingPrice('{{$i}}')">{{Str::upper($setting_stock_price['name'])}}</option>
                            @endforeach --}}
                        </select>
                    </div>
    
                </div>
            </div>
    
            @isset($data['stockList'])
                @foreach ($data['stockList'] as $stock)
    
                    @php
                        $text_success = '';
                        $image =  'stock/'.$stock->stock_store_id.'/'.$stock->image;   
                        $data['setupList'] = Stock::StockPriceProcessed($stock, $data['setupList']);
                        
                        $data['warehouseList'] = Warehouse::List('warehouse_stock_id', $stock->stock_id)
                        ->where('warehouse_store_id', $stock->stock_store_id)
                        ->where('warehouse_stock_quantity', '>', 0)
                        ->where('warehouse_type', 2)
                        ->get();
    
                        //get stock from other stores
                        $storeList = Store::List('root_store_id', $stock->stock_store_id)
                        ->orWhere('store_id', $stock->stock_store_id)
                        ->select('store_id')
                        ->get();
    
                        $data['warehouseStoreList'] = Warehouse::List('warehouse_stock_id', $stock->stock_id)
                        ->whereIn('warehouse_store_id', $storeList->toArray())
                        ->where('warehouse_stock_quantity', '>', 0)
                        //->where('warehouse_type', 2)
                        ->get();
    
                        if ($data['warehouseStoreList']) {
                            if($data['warehouseStoreList']->sum('warehouse_stock_quantity') > 0) {
                                $text_success = 'uk-text-success';
                            }
                        }
    
                    @endphp
    
                    <div>
    
                        <div class="uk-box-shadow-small uk-padding-small uk-border-rounded">
                            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                                <li><a href="#" uk-icon="thumbnails" class="uk-border-rounded"></a></li>
                                <li><a href="#" uk-icon="social" class="uk-border-rounded"></a></li>
                                <li><a href="#" uk-icon="list" class="uk-border-rounded"></a></li>
                            </ul>
                            
                            <ul class="uk-switcher uk-margin">
                                <li @if($data['warehouseList']->count() > 0) onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_store_id}}')" @endif>
                                    
                                    <b title="{{$stock->stock_id}}">{{$stock->stock_merchandise['stock_name']}}</b>
                                    <div class="uk-margin-remove-top" uk-grid>
                                        <div>
                                            @if ($data['setupList']['receipt']['stock']['stock_price_processed'])
                                                {{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock']['stock_price_processed'], 2) }}
                                            @endif
                                        </div>
                                        <div>
                                            <span class="uk-align-right">
                                                <b class="{{$text_success}}">
                                                    Qty - 
                                                </b> {{$data['warehouseList']->sum('warehouse_stock_quantity')}}
                                            </span>
                                        </div>
                                    </div>
                                </li>
    
                                <li>
                                    <div>
                                    
    
                                        <div class="uk-margin-small">
                                            <select class="uk-select" aria-label="Select">
                                                <option select disabled>SELECT</option>
                                                @foreach ($data['warehouseStoreList'] as $keyStockTransfer => $warehouse)
                                                    <optgroup label="{{$warehouse->store_name}}">
                                                        <option>{{$warehouse->warehouse_stock_quantity}}</option>
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <button @if ($data['warehouseStoreList']->count() == 0) disabled @endif class="uk-button uk-button-default uk-width-expand uk-border-rounded" uk-icon="triangle-right"></button>
                                        </div>
                                    </div>
                                </li>
    
                                <li>
                                    {{-- <div class="uk-width-auto" title="{{$stock->stock_id}}">
                                            <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
                                        </div> --}}
    
                                    <b>Overview</b>
    
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
                                        @if (count($data['setupList']) > 0)
                                            <div>{{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock']['stock_price'], 2) }}</div>
                                        @endif
                                    </div>
                                
                                    <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                                        <div>Offer</div>
                                        @if ( array_key_exists('decimal', $data['setupList']) )
                                            <div>
                                                @if ($data['setupList']['decimal']['discount_type'] == 0)
                                                    %
                                                @endif
                                                {{ MathHelper::FloatRoundUp( $data['setupList']['decimal']['discount_value'], 2) }}
                                            </div>
                                        @endif
                                    </div>
                                </li>
                            </ul>
                        </div>
                        
                        {{-- <div>
    
    
                           <div>
                                <div class="uk-inline">
                                    <div class="uk-padding-small uk-box-shadow-small">
                                        <span uk-icon="home">
                                            {{$data['warehouseList']->count()}}
                                        </span>
                                    </div>
                                    <div uk-dropdown="mode:click; pos: bottom-left; target: !.target; inset: true">
                                        
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="uk-padding-small uk-box-shadow-small" onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_merchandise['stock_name']}}','{{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock']['stock_price'], 2) }}')">
                                    <span uk-icon="arrow-right">
                                        {{$data['warehouseList']->count()}}
                                    </span>
                                </div>
                            </div>
                        </div> --}}
    
                    </div>
                
                @endforeach
            @endisset
            
        </div>
    
       
    
        <div class="uk-margin-top">
            @isset($data['stockList'])
                @include('partial.paginationPartial', ['paginator' => $data['stockList']])
            @endisset
        </div>
        
    </div>
</form>
