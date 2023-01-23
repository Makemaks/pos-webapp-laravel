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

{{-- @include('stock.partial.groupPartial') --}}
   
<form action="" id="stockFormID" method="POST">
    
    <div>
        
        <div class="uk-child-width-1-4@s uk-child-width-1-5@l uk-grid-small" uk-grid>

            @isset($data['stockList'])
                @foreach ($data['stockList'] as $stockItem)

                    @php
                        $text_success = '';
                        $image =  'stock/'.$stockItem->stock_store_id.'/'.$stockItem->image;
                        
                        //$data['setupList'] = Stock::StockPriceProcessed($stockItem, $data);
                      
                        $stockInitialize = Stock::StockInitialize($stockItem, $data['storeModel'], $data);
                        $data = Stock::StockPriceProcessed($stockInitialize, $data, $loop);

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
                          

                            <div class="uk-grid-small uk-margin-small"  uk-grid>
                                
                                <div>
                                    @include('home.stock.dropdown')
                                </div>

                            </div>
                            
                            <div>
                                <div onclick="Add('{{$stockItem->stock_id}}', '{{$stockItem->warehouse_store_id}}')" title="{{$stockItem->stock_id}}">
                                    {{Str::limit($stockItem->stock_merchandise['stock_name'], 10)}}
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
