@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\CountryHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    use App\Models\Warehouse;
    use App\Models\User;
    use App\Models\Stock;
    use App\Models\Setting;

    $currency = "";
    $route = Str::before(Request::route()->getName(), '.');  

    $default_currency = $data['settingModel']->setting_group['default_country'];
    $currency = CountryHelper::ISO()[$default_currency]['currencies'][0];
    $currency = '';

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
                    <td><a href="{{route('stock.edit', $stock->stock_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock->stock_id}}</a></td>
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

    <div>
        @include('stock.partial.groupPartial')
    </div>

    <hr>

    <div class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">

        <div class="uk-grid-match uk-child-width-1-4@s uk-grid-small" uk-grid>
        
            @isset($data['stockList'])
                @foreach ($data['stockList'] as $stock)
    
                    @php
                        $price = 0;
                        $storeID = $stock->stock_store_id;
                        $image =  'stock/'.$storeID.'/'.$stock->image;   
                        $stockOffer = [];
                        $stockCurrentOffer = [];
                        

                        $price = MathHelper::FloatRoundUp(Stock::StockCostCustomer($stock->stock_cost), 2);
                        //check if customer has price
                        if ($price == 0) {
                           //get original price
                            $price = MathHelper::FloatRoundUp(Stock::StockCostDefault($stock->stock_cost), 2);
                        }

                        //find discount
                        if ($stock->stock_merchandise['stock_offer_id']) {
                            $stockCurrentOffer = Setting::SettingCurrentOffer($stock, array_search('discount', Setting::DiscountType()));
                            $stockOffer = Setting::SettingCurrentOfferType( $stockCurrentOffer, $price );
                        }

                        if($stockOffer){
                            $stockOfferMin =  Stock::StockCostMin($stockOffer);
                        }

                    @endphp
    
                    <div>

                        <div title="{{$stock->stock_id}}" class="uk-padding-small uk-background-muted uk-border-rounded" onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_merchandise['stock_name']}}','{{$price}}')">
                            <div class="">
                                <div class="uk-grid-small uk-flex-middle" uk-grid>
                                    <div class="uk-width-auto">
                                        <img class="uk-border-circle" width="40" height="40" src="images/avatar.jpg">
                                       
                                    </div>
                                    <div class="uk-width-expand">
                                        @if (count($stockOffer) > 0)
                                            <h3 class="uk-margin-remove-bottom"> {{$currency}} {{ MathHelper::FloatRoundUp( $stockOfferMin['total']['price'], 2) }}</h3>
                                            
                                        @else
                                            <h3 class="uk-margin-remove-bottom">{{$currency}} {{$price}}</h3>
                                        @endif
                                    </div>
                                    <div>
                                        @if (count($stockOffer) > 0)
                                            <s class="uk-text-meta uk-margin-remove-top uk-text-danger">{{$currency}} {{$price}}</s>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                {{Str::ucfirst($stock->stock_merchandise['stock_name'])}}
                            </div>

                            <div>
                                <div class="uk-child-width-1-3" uk-grid>
                                    <div>
                                        @if ($stockCurrentOffer)
                                            <span class="uk-text-success" uk-icon="icon: star; ratio: 1.5"></span>
                                        @endif
                                   </div>

                                    <div>
                                        @if (count($stockOffer) > 0)

                                        
                                           {{ MathHelper::FloatRoundUp( $stockOfferMin['decimal']['discount_value'], 2)}}
                                            
                                        
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <div class="uk-align-right">
                                            @php
                                                $color = '';
                                                $warehouseStock = Warehouse::Available($stock->stock_id);
                                                
                                                if ($warehouseStock) {
                                                    if (Warehouse::WarehouseType()[$warehouseStock->warehouse_type] == 'transfer') {
                                                        $color = 'uk-text-warning';
                                                    }
                                                    else{
                                                        $color = 'uk-text-danger';
                                                    }
                                                }
                                        
                                            @endphp
                                            @if ($warehouseStock)
                                                <h3 {{$color}}">{{$warehouseStock->warehouse_quantity}}</h6>
                                            @endif
                                        </div>
                                    </div>
                                    
                                </div>
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