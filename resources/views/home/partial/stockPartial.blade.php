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
        
       

       <div class="uk-grid-small uk-child-width-auto uk-margin" uk-grid>

            <div>
                <select name="stock_group" id="stockGroupTypeID" class="uk-select">
                    <option disabled selected>FILTER... </option>
                    @foreach (Setting::SettingStockGroup() as $setting_stock_group)
                        <option onclick="stockGroup({{$loop->iteration}}, '{{$setting_stock_group}}', null)">{{Str::upper($setting_stock_group)}}</option>
                    @endforeach
                </select>
            </div>

            
            <div>
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

            <div>
                <div class="uk-search uk-search-default">
                    <span class="uk-search-icon-flip" uk-search-icon></span>
                    <input class="uk-search-input uk-width-expand" type="search" placeholder="Search" aria-label="Search">
                </div>
            </div>
       </div>


        <div class="uk-child-width-1-4@s uk-grid-small uk-text-small" uk-grid>

            @isset($data['stockList'])
                @foreach ($data['stockList'] as $stockItem)

                    @php
                        $text_success = '';
                        $image =  'stock/'.$stockItem->stock_store_id.'/'.$stockItem->image;
                        
                        //$data['setupList'] = Stock::StockPriceProcessed($stockItem, $data['setupList']);
                      
                        $data['setupList'] = Stock::StockInit($stockItem, $data['storeModel'], $data['setupList']);
                        

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
                        ->orderBy('warehouse_store_id')
                        //->where('warehouse_type', 2)
                        ->get()
                        ->groupBy('warehouse_store_id');

                        

                        if ($data['warehouseStoreList']) {
                            if($data['warehouseStoreList']->sum('warehouse_stock_quantity') > 0) {
                                $text_success = 'uk-text-success';
                            }
                        }

                    @endphp

                    <div>
                       
                        <div class="uk-box-shadow-small uk-padding-small">
                           

                            {{-- <div>
                                @include('receipt.partial.controlPartial')
                            </div> --}}

                                <div class="">
                                    
                                    
                                </div>

                                <div uk-grid>
                                    <div class="uk-width-expand">
                                        {{Str::limit($stockItem->stock_merchandise['stock_name'], 10)}}
                                    </div>

                                    <div>@include('home.partial.settingOffer')</div>
                                    
                                </div>
                               

                                <div class="uk-button-group">
                                    <button onclick="Add('{{$stockItem->stock_id}}', '{{$stockItem->warehouse_store_id}}')" title="{{$stockItem->stock_id}}" class="uk-button uk-button-default uk-border-rounded uk-button-small" type="button">
                                        <span uk-icon="icon: cart"></span>
                                        {{-- <span uk-icon="icon: plus"></span> --}}
                                    </button>
                                    
                                    <div class="uk-inline">
                                        <button class="uk-button uk-button-default uk-border-rounded uk-button-small" type="button" uk-icon="database"></button>
                                            <div uk-dropdown="mode: click;pos:bottom-right">
                                                <ul class="uk-list uk-list-collapse uk-list-divider">
                                                    @foreach ($data['warehouseStoreList'] as $warehouseStoreKey => $warehouseStore)
                                                    
                                                        <li>
                                                            <span>
                                                                <button class="uk-button uk-button-default uk-border-rounded uk-button-small" type="button" uk-icon="cart"></button>
                                                           </span>
                                                            {{$warehouseStore->first()->store_name}} - {{$warehouseStore->sum('warehouse_stock_quantity')}}

                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                    </div>
                                </div>
                               
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
