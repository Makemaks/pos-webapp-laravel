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
                                       {{--  <td>
                                            <button class="uk-button uk-button-danger uk-border-rounded" onclick="">{{$stock}}</button>
                                        </td> --}}
                                
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

        <form action="" class="uk-form-stacked"> 

            @php
               
                    $userModel = User::Account('account_id', Auth::user()->user_account_id)
                    ->first();
            
                    $storeModel = Store::Account('store_id',$userModel->store_id)->first();
                    $storeList = Store::List('root_store_id', $storeModel->store_id)
                    ->get();
              
            @endphp
        
            
            <input name="stockroom_user_id" value="{{Auth::user()->user_id}}" hidden>
            <input name="stockroom_stock_id" value="{{$data['stockModel']->stock_id}}" hidden>
            
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">REFERENCE</label>
                <div class="uk-form-controls">
                    <input class="uk-input" name="stockroom_reference" type="text">
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">TYPE</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="form-stacked-select" name="store_id" name="stockroom_type">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach (Stockroom::Type() as $key => $stock)
                            <option value="{{$key}}" class="uk-input">
                                {{$stock}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">STATUS</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="form-stacked-select" name="store_id" name="stockroom_status">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach (Stockroom::Status() as $key => $stock)
                            <option value="{{$key}}" class="uk-input">
                                {{$stock}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
                   
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">STORE</label>
                <div class="uk-form-controls">
                    <select class="uk-select" id="form-stacked-select" name="stockroom_store_id">
                        <option value="" selected disabled>SELECT ...</option>
                        @if($storeList)
                            @foreach ($storeList as $store)
                                <option value="{{$store->store_id}}" class="uk-input">
                                    {{$store->store_name}}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">QUANTITY</label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="number" name="stockroom_quantity">
                </div>
            </div>

            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-text">PRICE</label>
                <div class="uk-form-controls">
                    <input class="uk-input" type="number" name="stockroom_price">
                </div>
            </div>
                        
            <div class="uk-margin">
                <label class="uk-form-label" for="form-stacked-select">NOTE</label>
                <div class="uk-form-controls">
                    <textarea name="stockroom_note" class="uk-textarea" id="" cols="30" rows="10"></textarea>
                </div>
            </div>
            
           <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
             
        </form>
    </li>
</ul>