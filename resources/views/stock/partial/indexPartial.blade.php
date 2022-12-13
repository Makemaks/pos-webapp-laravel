@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\CountryHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    
    use App\Models\User;
    use App\Models\Stock;
    use App\Models\Setting;

    $route = Str::before(Request::route()->getName(), '.');
    
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




@if ($route != 'home')

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
                    <td><a href="{{route('stock.edit', $stock->stock_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock->stock_id}}</a></td>
                    <td>{{$stock->stock_merchandise['stock_name']}}</td>
                    <td>
                        {{-- @if ( array_key_exists($stock->stock_merchandise['plu_id'], $data['settingModel']->setting_stock_set) )
                            {{$data['settingModel']->setting_stock_set[$stock->stock_merchandise['plu_id']]['name']}}
                        @endi --}}
                    </td>

                    <td>{{$stock->stock_merchandise['random_code']}}</td>
                    <td>
                        @if ( array_key_exists($stock->stock_merchandise['group_id'], $data['settingModel']->setting_stock_set) )
                            {{$data['settingModel']->setting_stock_set[$stock->stock_merchandise['group_id']]['name']}}
                        @endif
                    </td>
                    <td>
                        {{-- dept --}}
                        @if ( array_key_exists($stock->stock_merchandise['category_id'], $data['settingModel']->setting_stock_set) )
                            {{$data['settingModel']->setting_stock_set[$stock->stock_merchandise['category_id']]['name']}}
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
                            $price = MathHelper::FloatRoundUp(Stock::StockPriceDefault($stock->stock_price), 2);
                           
                        @endphp
                       {{$price}}
                    </td>
                    {{-- <td>{{$stock->stock_merchandise['stock_quantity']}}</td> --}}
                </tr>
           @endforeach
        </tbody>
    </table>
@else

    @include('stock.partial.groupPartial')
   
    <div class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">
            
        <div class="uk-grid-match uk-child-width-1-4@s uk-grid-small uk-padding-small" uk-grid>
        
            <div>
                <div class="uk-padding-small uk-box-shadow-small">
                    <select name="" id="" class="uk-select">
                        <option value="">SELECT</option>
                        @foreach (Setting::SettingStockGroup() as $setting_stock_group)
                            <option onclick="stockGroup({{$loop->iteration}}, '{{$setting_stock_group}}', null)">{{Str::ucfirst($setting_stock_group)}}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            @isset($data['stockList'])
                @foreach ($data['stockList'] as $stock)

                    @php
                        
                        $storeID = $stock->stock_store_id;
                        $image =  'stock/'.$storeID.'/'.$stock->image;   
                        $stockPriceFinalize = Stock::StockPriceProcessed($stock);
                    @endphp

                    <div>

                        <div class="uk-padding-small uk-box-shadow-small">
                            
                            <div>
                                @include('stock.partial.buttonPartial')
                            </div>
                            
                            <div title="Price">
                                <p class="uk-text-small uk-margin-remove-bottom">
                                    @if ($stockPriceFinalize['stock_offer_processed']['stock_price_processed'])
                                        {{ MathHelper::FloatRoundUp( $stockPriceFinalize['stock_offer_processed']['stock_price_processed'], 2) }}    
                                    @else
                                        {{ MathHelper::FloatRoundUp( $stockPriceFinalize['stock_offer_processed']['stock_price'], 2) }}    
                                    @endif
                                    
                                </p>
                            </div>

                        </div>

                        <div>
                            <div class="uk-padding-small uk-box-shadow-small" onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_merchandise['stock_name']}}','{{ MathHelper::FloatRoundUp( $stockPriceFinalize['stock_offer_processed']['stock_price'], 2) }}')">
                                <span uk-icon="arrow-right"></span>
                            </div>
                        </div>

                    </div>
                
                @endforeach
            @endisset
            
        </div>

        <div class="uk-margin-large">
            @isset($data['stockList'])
                @include('partial.paginationPartial', ['paginator' => $data['stockList']])
            @endisset
        </div>
        
    </div>

@endif