@php
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Helpers\StringHelper;
    use App\Models\Scheme;
    use App\Models\User;

    $route = Str::before(Request::route()->getName(), '.');  
    $currency = CurrencyHelper::Currency();

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



@if (User::UserType()[Auth::User()->user_type] == 'Super Admin' || User::UserType()[Auth::User()->user_type] == 'User')
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
                    <td>{{$stock->stock_merchandise['master_plu']}}</td>
                    <td>{{$stock->stock_merchandise['random_code']}}</td>
                    
                    <td>
                       {{--  @foreach ($data['settingModel']->setting_stock_group_category_plu as $item)
                            @if ($item['type'] == 1 && $stock->stock_merchandise['group_id'])
                                {{$data['settingModel']->setting_stock_group_category_plu[$stock->stock_merchandise['group_id']]['description']}}
                            @endif
                        @endforeach --}}
                        {{$data['settingModel']->setting_stock_group_category_plu[$stock->stock_merchandise['group_id']]['description']}}
                    </td>
                    <td>
                        {{-- dept --}}
                       {{--  @foreach ($data['settingModel']->setting_stock_group_category_plu as $item)
                            @if ($item['type'] == 0 && $stock->stock_merchandise['category_id'])
                                {{$data['settingModel']->setting_stock_group_category_plu[$stock->stock_merchandise['category_id']]['description']}}
                            @endif
                        @endforeach --}}
                        {{$data['settingModel']->setting_stock_group_category_plu[$stock->stock_merchandise['category_id']]['description']}}
                    </td>
                    <td>
                       @if ($stock->stock_merchandise['stock_vat'] == 'null')
                            @foreach ($data['settingModel']->setting_vat as $item)
                                @if ($item['default'] == 0)
                                    {{$item['rate']}}
                                @endif
                            @endforeach
                       @else
                            {{$stock->stock_merchandise['stock_vat']}}
                       @endif

                    </td>
                    <td>
                        @php
                            $cost = 0;
                            foreach ($stock->stock_cost as $stock_cost){
                                    $cost = MathHelper::FloatRoundUp($stock_cost['price'], 2);
                            }
                           
                        @endphp
                       {{$cost}}
                    </td>
                    <td>{{$stock->stock_merchandise['stock_quantity']}}</td>
                </tr>
           @endforeach
        </tbody>
    </table>
@else
    
    <div class="uk-grid-match uk-child-width-1-4@m uk-child-width-1-4@s" uk-grid>
        @foreach ($data['stockList'] as $stock)

            @php
                $storeID = $stock->stock_account_id;
                $image =  'stock/'.$storeID.'/'.$stock->image;      
                $price = CurrencyHelper::Format($stock->stock_cost);  
                /* $schemeList = Scheme::stock('schemetable_id',  $stock->stock_id)->get(); */
            @endphp


            <div>
                <div class="uk-card uk-card-default uk-card-small uk-card-body">
                        @if ( $stock != null && $stock->stock_image != null && 
                            Storage::disk('public')->has('uploads/'.$stock->stock_image))
                                <img src="{{asset('/storage/uploads/'.$stock->stock_image)}}" class="uk-image">
                        @else
                            <img src="{{asset('/storage/uploads/placeholder.png')}}" class="uk-image">
                        @endif
                    <div>
                        <ul class="uk-iconnav uk-padding-small">
                            <li><a href="{{route('stock.edit', $stock->stock_id)}}" class="" uk-icon="icon: pencil"></a></li>
                            {{-- <li><a href="{{route('init.dashboard', ['stock', $stock->stock_id])}}" uk-icon="icon: history"></a></li> --}}
                            {{-- <li><span class="uk-card-badge uk-label">{{$stock->stock_quantity}}</span></li> --}}
                        </ul>
                    </div>

                    <a class="uk-link-reset" onclick="Add('{{$stock->stock_id}}', '{{$stock->stock_name}}', '{{$price}}')">
                        <div class="uk-padding-small" style="background-color: #{{StringHelper::getColor()}}">
                            
                            <div class="uk-text-center uk-light">
                                <div class="uk-text-lead">{{$stock->stock_name}}</div>
                                <div class="uk-text-meta uk-margin-remove-top">{{$stock->stock_brand}}</div>
                                <div class="uk-text-lead">
                                    {{CurrencyHelper::Currency()}}{{$price}}
                                    {{-- @if ($schemeList->count() > 0)
                                        <span class="uk-text-danger">*</span>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    </a>

                    @if ($route == 'home')
                        <div class="uk-margin-top">
                            @include('partial.controlsPartial', [
                                'cartValue' => $stock->stock_id,
                                'quantity' => 1,
                            ])
                        </div>
                    @endif
                </div>
            </div>
    
        @endforeach
    </div>
    @include('partial.paginationPartial', ['paginator' => $data['stockList']])
@endif