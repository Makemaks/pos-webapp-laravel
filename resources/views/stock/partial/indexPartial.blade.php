@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\CountryHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    use App\Models\Warehouse;
    use App\Models\User;
    use App\Models\Stock;

    $currency = "";
    $route = Str::before(Request::route()->getName(), '.');  

    $default_currency = $data['settingModel']->setting_group['default_country'];
    $currency = CountryHelper::ISO()[$default_currency]['currencies'][0];
   

    $tableHeader = [
        'ID',
        'Product',
        'PLU',
        'Code',
        'Group',
        'Dept',
        'VAT',
        'Price',
        'Qty',
    ];

    
@endphp




@if (User::UserType()[Auth::User()->user_type] == 'Super Admin' && 
User::UserType()[Auth::User()->user_type] == 'Admin' && $route != 'home-api')

    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
        <thead>
            <tr>
               @foreach ($tableHeader as $item)
                    <th>{{$item}}</th>
               @endforeach
            </tr>
        </thead>
        <tbody>
           @foreach ($data['stockList'] as $stock)
                <tr>
                    <td><a href="{{route('stock.edit', $stock->stock_id)}}" class="uk-button uk-button-danger uk-border-rounded">{{$stock->stock_id}}</a></td>
                    <td>{{$stock->stock_merchandise['stock_name']}}</td>

                    <td>
                        @if ( array_key_exists($stock->stock_merchandise['plu_id'], $data['settingModel']->setting_stock_group) )
                            {{$data['settingModel']->setting_stock_group[$stock->stock_merchandise['plu_id']]['name']}}
                        @endif
                    </td>

                    <td>{{$stock->stock_merchandise['random_code']}}</td>
                    <td>
                        @if ( array_key_exists($stock->stock_merchandise['group_id'], $data['settingModel']->setting_stock_group) )
                            {{$data['settingModel']->setting_stock_group[$stock->stock_merchandise['group_id']]['name']}}
                        @endif
                    </td>
                    <td>
                        {{-- dept --}}
                        @if ( array_key_exists($stock->stock_merchandise['category_id'], $data['settingModel']->setting_stock_group) )
                            {{$data['settingModel']->setting_stock_group[$stock->stock_merchandise['category_id']]['name']}}
                        @endif
                    </td>
                    <td>
                       @if ($stock->stock_merchandise['stock_vat_id'])
                         {{$stock->stock_merchandise['stock_vat_id']}}
                       @else
                            @foreach ($data['settingModel']->setting_vat as $item)
                                @if ($item['default'] == 0)
                                    {{$item['rate']}}
                                @endif
                            @endforeach
                       @endif

                    </td>
                    <td>
                        @php
                            $price = 0;
                            $price = MathHelper::FloatRoundUp(Stock::StockCostDefault($stock->stock_cost), 2);
                           
                        @endphp
                       {{$price}}
                    </td>
                    {{-- <td>{{$stock->stock_merchandise['stock_quantity']}}</td> --}}
                </tr>
           @endforeach
        </tbody>
    </table>
@else

    <div class="uk-grid-collapse uk-child-width-1-4@m" uk-grid>

        <div>
                
            <div>
                <div class="uk-height-small uk-box-shadow-small uk-border-rounded">
                
                    <div class="uk-padding-small uk-grid-small" uk-grid>

                        <div>
                            <button onclick="setFocus('barcodeInputID')" uk-icon="list" class="uk-button uk-button-default uk-border-rounded"></button>
                        </div>
                        
                        <div>
                            <button onclick="createSearch()" uk-icon="plus" class="uk-button uk-button-default uk-border-rounded"></button>
                        </div>

                        <div class="uk-text-small  uk-text-bold"></div>
                        <div class="uk-text-meta uk-margin-remove-top"></div>

                       
                    </div>
                    
                </div>
            </div>

            
        </div>

        @foreach ($data['stockList'] as $stock)

            @php
                $price = 0;
                $storeID = $stock->stock_store_id;
                $image =  'stock/'.$storeID.'/'.$stock->image;    
                $price = MathHelper::FloatRoundUp(Stock::StockCostDefault($stock->stock_cost), 2);
                /* $schemeList = Scheme::stock('schemetable_id',  $stock->stock_id)->get(); */
            @endphp

            <div>

                
                <a class="uk-link-reset" onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_merchandise['stock_name']}}','{{$price}}', {{ Stock::StockVAT($stock) }})">
                    <div class="uk-height-small uk-box-shadow-small uk-border-rounded">
                    
                        <div class="uk-padding-small">
                            <div class="uk-text-small  uk-text-bold">{{Str::ucfirst($stock->stock_merchandise['stock_name'])}}</div>
                            <div class="uk-text-meta uk-margin-remove-top">{{$stock->stock_brand}}</div>
                            <div>
                                {{$currency}}{{$price}}
                            </div>

                            <div class="uk-grid-small uk-child-width-expand@s uk-margin" uk-grid>
                                <div>
                                    <div class="">
                                        @php
                                            $stockOffer = Stock::CurrentOffer($stock);
                                        @endphp

                                        @if ($stockOffer)
                                            <span class="uk-text-lead uk-text-success"> {{count($stockOffer)}}</span>
                                        @endif

                                    </div>
                                </div>
                                <div>
                                    <div class="uk-align-right">
                                        @php
                                            $color = '';
                                            $warehouseStock = Warehouse::Available($stock->stock_id);
                                            
                                            if ($warehouseStock->count() > 0) {
                                                if (Warehouse::WarehouseType()[$warehouseStock->first()->warehouse_type] == 'transfer') {
                                                    $color = 'uk-text-muted';
                                                }
                                            }else{
                                                $color = 'uk-text-danger';
                                            }
                                       
                                        @endphp
                                        <span class="uk-text-lead {{$color}}">{{$warehouseStock->sum('warehouse_quantity')}}</span>
                                    </div>
                                </div>
                                
                            </div>
                            
                        </div>
                        
                    </div>
                </a>

                
            </div>
    
        @endforeach
    </div>
    @include('partial.paginationPartial', ['paginator' => $data['stockList']])
@endif