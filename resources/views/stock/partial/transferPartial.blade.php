@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Warehouse;
    use Carbon\Carbon;
   
    $warehouseList = new Stock();
    
@endphp


<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li><a href="#" uk-icon="list"></a></li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>
        <h3>TRANSFERS</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-table-responsive">
            <thead>
                <tr>
                    <th>REF</th>

                        @isset($data['warehouseList'])
                            @foreach ($data['warehouseList']->toArray()[1] as $keystock => $item)
                                @if ($keystock != 'warehouse_id' && $keystock != 'warehouse_stock_id' && $keystock != 'created_at' &&	$keystock != 'updated_at')
                                    <th>{{Str::after($keystock, 'warehouse_')}}</th>
                                @endif
                            @endforeach
                        @endisset
                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
            
                @isset($data['warehouseList'])
                    @foreach ($data['warehouseList']->toArray() as $keyStockTransfer => $warehouseList)
                        
                        <tr>
                        
                                @foreach ($warehouseList as $keystock => $stock)
                                
                                    @if ($keystock == 'warehouse_id')
                                        <input class="uk-input" type="text" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}" hidden>
                                        <td>
                                                <button class="uk-button uk-button-default uk-border-rounded" onclick="">{{$stock}}</button>
                                        </td>
                                
                                    @elseif ($keystock == 'warehouse_note' || $keystock == 'warehouse_description' || $keystock == 'warehouse_reference')
                                        <td>
                                            <input class="uk-input" type="text" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                                        </td>

                                    @elseif($keystock == 'warehouse_price' || $keystock == 'warehouse_quantity')
                                        <td>
                                            <input class="uk-input" type="number" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                                        </td>
                                    @elseif($keystock == 'warehouse_status')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                
                                                    @foreach (Warehouse::WarehouseStatus() as $store)
                                                        <option value="{{$stock}}" class="uk-input">
                                                            {{$store}}
                                                        </option>
                                                    @endforeach
                                                
                                            </select>
                                        </td>
                                    @elseif($keystock == 'warehouse_type')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                
                                                    @foreach (Warehouse::WarehouseType() as $key => $stock)
                                                        <option value="{{$stock}}" class="uk-input">
                                                            {{$stock}}
                                                        </option>
                                                    @endforeach
                                            
                                            </select>
                                        </td>
                                    @elseif($keystock == 'warehouse_store_id' || $keystock == 'warehouse_user_id')
                                        <td>
                                            <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock}}</a>
                                        </td>
                                    

                                        {{-- @elseif ($keystock == 'warehouse_note' || $keystock == 'warehouse_description' || $keystock == 'warehouse_reference' || $keystock == 'warehouse_reason') --}}
                                    @elseif ($keystock == 'warehouse_note' || $keystock == 'warehouse_description' || $keystock == 'warehouse_reference')
                                        <td>
                                            <input class="uk-input" type="text" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                                        </td>
                                    @elseif($keystock == 'warehouse_price' || $keystock == 'warehouse_price_override' || $keystock == 'warehouse_quantity')
                                        <td>
                                            <input class="uk-input uk-form-width-small" type="number" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                                        </td>
                                    @elseif($keystock == 'warehouse_status')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                
                                                    @foreach (Warehouse::WarehouseStatus() as $store)
                                                        <option value="{{$stock}}" class="uk-input">
                                                            {{$store}}
                                                        </option>
                                                    @endforeach
                                                
                                            </select>
                                        </td>
                                    @elseif($keystock == 'warehouse_type')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="warehouse[{{$keyStockTransfer}}][{{$keystock}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                
                                                    @foreach (Warehouse::WarehouseType() as $key => $stock)
                                                        <option value="{{$stock}}" class="uk-input">
                                                            {{$stock}}
                                                        </option>
                                                    @endforeach
                                            
                                            </select>
                                        </td>
                                    @elseif($keystock == 'warehouse_store_id' || $keystock == 'warehouse_user_id' || $keystock == 'warehouse_address_id' || $keystock == 'warehouse_company_id')
                                        
                                            <td>
                                                @if ($stock)
                                                    <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock}}</a>
                                                @endif
                                            </td>
                                        
                                    @endif
                                            
                                @endforeach
                                <td>
                                    <button class="uk-button uk-button-default uk-border-rounded" uk-icon="trash" onclick="deleteStockTransfer({{$stock}})"></button>
                                </td>
                        </tr>    
                    @endforeach
                @endisset
                
            </tbody>
        </table>
    </li>

                              
               
           

    <li>
            <form action="">
                @include('warehouse.partial.createPartial')
                <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push"></button>
         
            </form>
    </li>
</ul>