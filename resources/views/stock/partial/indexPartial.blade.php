@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\CountryHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    
    use App\Models\User;
    use App\Models\Stock;
    use App\Models\Setting;
    use App\Models\Warehouse;

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
                   @if ($stock->stock_setting_vat)
                     {{$stock->stock_setting_vat}}
                   @else
                        @foreach ($data['settingModel']->setting_vat as $item)
                            @if ($item['default'] == 0)
                                {{$item['rate']}}
                            @endif
                        @endforeach
                   @endif

                </td>
                <td>
                    {{MathHelper::FloatRoundUp(Stock::StockPriceDefault($stock->stock_price), 2)}}
                </td>
                {{-- <td>{{$stock->stock_merchandise['stock_quantity']}}</td> --}}
            </tr>
       @endforeach
    </tbody>
</table>
