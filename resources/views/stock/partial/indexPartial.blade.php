@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\CountryHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    use App\Models\Scheme;
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


@if (User::UserType()[Auth::User()->user_type] == 'Super Admin' || User::UserType()[Auth::User()->user_type] == 'User' && $route != 'home')
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
                    <td>{{$stock->stock_merchandise['plu_id']}}</td>
                    <td>{{$stock->stock_merchandise['random_code']}}</td>
                    
                    <td>
                        @if ($stock->stock_merchandise['group_id'])
                            {{$data['settingModel']->setting_stock_group[$stock->stock_merchandise['group_id']]['description']}}
                        @endif
                    </td>
                    <td>
                        {{-- dept --}}
                        @if ($stock->stock_merchandise['category_id'])
                            {{$data['settingModel']->setting_stock_group[$stock->stock_merchandise['category_id']]['description']}}
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
    
    <div class="uk-grid-collapse uk-child-width-1-3@m" uk-grid>
        @foreach ($data['stockList'] as $stock)

            @php
                $price = 0;
                $storeID = $stock->stock_store_id;
                $image =  'stock/'.$storeID.'/'.$stock->image;    
                $price = MathHelper::FloatRoundUp(Stock::StockCostDefault($stock->stock_cost), 2);
                /* $schemeList = Scheme::stock('schemetable_id',  $stock->stock_id)->get(); */
            @endphp

            <div>
                
                <a class="uk-link-reset" onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_merchandise['stock_name']}}', '{{$price}}')">
                    <div class="uk-height-small uk-text-center uk-light" style="background-color: #{{StringHelper::getColor()}}">
                    
                        <div class="">
                            <div class="uk-text-small">{{$stock->stock_merchandise['stock_name']}}</div>
                            <div class="uk-text-meta uk-margin-remove-top">{{$stock->stock_brand}}</div>
                            <div class="uk-text-small">
                                {{$currency}}{{$price}}
                                {{-- @if ($schemeList->count() > 0)
                                    <span class="uk-text-danger">*</span>
                                @endif --}}
                            </div>
                        </div>
                        
                    </div>
                </a>

                
            </div>
    
        @endforeach
    </div>
    @include('partial.paginationPartial', ['paginator' => $data['stockList']])
@endif