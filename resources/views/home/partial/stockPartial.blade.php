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
        
       

       <div class="uk-margin">

            <div class="uk-inline">
                <button class="uk-button uk-button-default" type="button" uk-icon="chevron-down">SEARCH</button>
                <div uk-dropdown="mode: click">
                    <select name="stock_group" id="stockGroupTypeID" class="uk-select">
                        <option disabled selected>FILTER... </option>
                        @foreach (Setting::SettingStockGroup() as $setting_stock_group)
                            <option onclick="stockGroup({{$loop->iteration}}, '{{$setting_stock_group}}', null)">{{Str::upper($setting_stock_group)}}</option>
                        @endforeach
                    </select>

                    <div class="uk-margin">
                        <div class="uk-search uk-search-default">
                            <span class="uk-search-icon-flip" uk-search-icon></span>
                            <input class="uk-search-input uk-width-expand" type="search" placeholder="Search" aria-label="Search">
                        </div>
                        
                    </div>
                </div>
            </div>

            <div class="uk-inline">
                <button class="uk-button uk-button-default" type="button" uk-icon="chevron-down">PRICE</button>
                <div uk-dropdown="mode: click">
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
       </div>


        <div class="uk-child-width-1-4@s uk-grid-small uk-text-small" uk-grid>

            @isset($data['stockList'])
                @foreach ($data['stockList'] as $stockItem)

                    @php
                        $text_success = '';
                        $image =  'stock/'.$stockItem->stock_store_id.'/'.$stockItem->image;
                        
                        $stockItemInit = Stock::StockInit($stockItem, $data['storeModel'], $data['setupList']);

                        $data['warehouseList'] = Warehouse::List('warehouse_stock_id', $stockItem->stock_id)
                        ->where('warehouse_store_id', $stockItem->warehouse_store_id)
                        ->where('warehouse_stock_quantity', '>', 0)
                        //->where('warehouse_type', 2)
                        ->get();

                        //get stock from other stores
                        $storeList = Store::List('store_id', $stockItem->warehouse_store_id)
                        ->orWhere('root_store_id', $stockItem->warehouse_store_id)
                        ->select('store_id')
                        ->get();


                        $data['warehouseStoreList'] = Warehouse::List('warehouse_stock_id', $stockItem->stock_id)
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
                       
                        <div class="uk-height-small uk-box-shadow-small">

                                <div class="uk-padding-remove-top">
                                    @include('home.partial.settingOffer')
                                    <span onclick="Add('{{$stockItem->stock_id}}', '{{$stockItem->warehouse_store_id}}')" class="uk-text-bold" title="{{$stockItem->stock_id}}">
                                        {{Str::limit($stockItem->stock_merchandise['stock_name'], 10)}}
                                    </span>
                                   
                                </div>

                                <div class="uk-align-right">
                                    <span class="uk-inline">
                                        <button type="button" uk-icon="home"></button>
                                            <div uk-dropdown="mode: click;pos:bottom-right">
                                                <ul>
                                                    @foreach ($data['warehouseStoreList'] as $keyStockTransfer => $warehouse)
                                                        <li>{{$warehouse->store_name}} - {{$warehouse->warehouse_stock_quantity}}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                    </span>
                                </div>
                               

                                {{-- <li>
                                            <div class="uk-width-auto" title="{{$stockItem->stock_id}}">
                                                    <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
                                            </div>

                                            <b>Overview</b>

                                            <div class="uk-child-width-1-2 uk-margin-remove-top" uk-grid>
                                                <div>VAT</div>
                                                <div class="uk-text-small">
                                                    @if ($stockItem->stock_merchandise['stock_vat_id'] == 'null')
                                                        @foreach ($data['settingModel']->setting_vat as $item)
                                                            @if ($item['default'] == 0)
                                                                {{ MathHelper::FloatRoundUp($item['rate'], 2) }}
                                                            @endif
                                                        @endforeach
                                                    @else
                                                        @if (array_key_exists( $stockItem->stock_merchandise['stock_vat_id'], $data['settingModel']->setting_vat) )
                                                            {{ MathHelper::FloatRoundUp($data['settingModel']->setting_vat[ $stockItem->stock_merchandise['stock_vat_id'] ]['rate'], 2) }}
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
                                        </li> --}}
                                
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
                                        <div class="uk-padding-small uk-box-shadow-small" onclick="Add('{{$stockItem->stock_id}}', '{{$stockItem->stock_merchandise['stock_name']}}','{{ MathHelper::FloatRoundUp( $data['setupList']['receipt']['stock']['stock_price'], 2) }}')">
                                            <span uk-icon="arrow-right">
                                                {{$data['warehouseList']->count()}}
                                            </span>
                                        </div>
                                    </div>
                                </div> --}}

                        </div>

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
