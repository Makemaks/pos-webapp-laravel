@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Stockroom;
    use Carbon\Carbon;
   
    $stockroomList = new Stock();
    
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

                    @foreach ($data['stockroomList']->toArray()[1] as $keystock => $item)
                        @if ($keystock != 'stockroom_id' && $keystock != 'stockroom_stock_id' && $keystock != 'created_at' &&	$keystock != 'updated_at')
                            <th>{{Str::after($keystock, 'stockroom_')}}</th>
                        @endif
                    @endforeach
                    
                    <th></th>
                </tr>
            </thead>
            <tbody>
            
                
                    @foreach ($data['stockroomList']->toArray() as $keyStockTransfer => $stockroomList)
                        
                        <tr>
                           
                            @foreach ($stockroomList as $keystock => $stock)
                            
                                    @if ($keystock == 'stockroom_id')
                                        <input class="uk-input" type="text" name="stockroom[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}" hidden>
                                       <td>
                                            <button class="uk-button uk-button-danger uk-border-rounded" onclick="">{{$stock}}</button>
                                       </td>
                                
                                    @elseif ($keystock == 'stockroom_note' || $keystock == 'stockroom_description' || $keystock == 'stockroom_reference')
                                        <td>
                                            <input class="uk-input" type="text" name="stockroom[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                                        </td>
                                    @elseif($keystock == 'stockroom_price' || $keystock == 'stockroom_quantity')
                                        <td>
                                            <input class="uk-input" type="number" name="stockroom[{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                                        </td>
                                    @elseif($keystock == 'stockroom_status')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="stockroom[{{$keyStockTransfer}}][{{$keystock}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                
                                                    @foreach (Stockroom::Status() as $store)
                                                        <option value="{{$stock}}" class="uk-input">
                                                            {{$store}}
                                                        </option>
                                                    @endforeach
                                                
                                            </select>
                                        </td>
                                    @elseif($keystock == 'stockroom_type')
                                        <td>
                                            <select class="uk-select" id="form-stacked-select" name="stockroom[{{$keyStockTransfer}}][{{$keystock}}]">
                                                <option value="" selected disabled>SELECT ...</option>
                                                
                                                    @foreach (Stockroom::Type() as $key => $stock)
                                                        <option value="{{$stock}}" class="uk-input">
                                                            {{$stock}}
                                                        </option>
                                                    @endforeach
                                            
                                            </select>
                                        </td>
                                    @elseif($keystock == 'stockroom_store_id' || $keystock == 'stockroom_user_id')
                                        <td>
                                            <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-danger uk-border-rounded">{{$stock}}</a>
                                        </td>
                                    @endif

                                    
                                    
                            @endforeach
                            <td>
                                <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockTransfer({{$stock}})"></button>
                            </td>
                        </tr>    
                    @endforeach
               
            </tbody>
        </table>
    </li>

    <li>

         <h3>TRANSFERS</h3>
        <form action="" class="uk-form-stacked"> 

            @php
               
                    $userModel = User::Account('account_id', Auth::user()->user_account_id)
                    ->first();
            
                    $storeModel = Store::Account('store_id',$userModel->store_id)->first();
                    $storeList = Store::List('root_store_id', $storeModel->store_id)
                    ->get();
              
            @endphp
        
            
            <input name="form[stockroom][stockroom_user_id]" value="{{Auth::user()->user_id}}" hidden>
            <input name="form[stockroom][stockroom_stock_id]" value="{{$data['stockModel']->stock_id}}" hidden>
            
            @foreach ($data['stockroomList']->toArray() as $keyStockTransfer => $stockroomList)
                        
            
                @foreach ($stockroomList as $keystock => $stock)
                
                       
                        @if ($keystock == 'stockroom_reference')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="text" name="form[stockroom][{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'stockroom_price' || $keystock == 'stockroom_quantity')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <input class="uk-input" type="number" name="form[stockroom][{{$keyStockTransfer}}][{{$keystock}}]" value="{{$stock}}">
                            </div>
                        @elseif($keystock == 'stockroom_store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[stockroom][{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach ($storeList as $store)
                                            <option value="{{$store->store_id}}" class="uk-input">
                                                {{$store->store_name}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'stockroom_status')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[stockroom][{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Stockroom::Status() as $store)
                                            <option value="{{$stock}}" class="uk-input">
                                                {{$store}}
                                            </option>
                                        @endforeach
                                    
                                </select>
                            </div>
                        @elseif($keystock == 'stockroom_type')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <select class="uk-select" id="form-stacked-select" name="form[stockroom][{{$keyStockTransfer}}][{{$keystock}}]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    
                                        @foreach (Stockroom::Type() as $key => $stock)
                                            <option value="{{$stock}}" class="uk-input">
                                                {{$stock}}
                                            </option>
                                        @endforeach
                                
                                </select>
                            </div>
                        @elseif($keystock == 'stockroom_store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <a href="{{route('store.edit', $stock)}}" class="uk-button uk-button-danger uk-border-rounded">{{$stock}}</a>
                            </div>
                        @elseif($keystock == 'stockroom_note' || $keystock == 'stockroom_description')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{ Str::upper(Str::after($keystock, '_' )) }}</label>
                                <div class="uk-form-controls">
                                    <textarea name="form[stockroom][{{$keyStockTransfer}}][{{$keystock}}]" class="uk-textarea" id="" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                        @endif

                        
                        
                @endforeach
                            
                @break
            
            @endforeach
   
                        
           
            
           <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
             
        </form>
    </li>
</ul>