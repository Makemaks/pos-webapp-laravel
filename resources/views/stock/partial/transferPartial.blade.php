@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use Carbon\Carbon;

     $iconArray = [
        "reply",
       "forward"
];

    $stockModel = new Stock();
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
                    

                            @foreach ($data['stockModel']->stock_transfer[1] as $key => $item)
                                
                                    <th>
                                        
                                        @if ($key == Str::contains($key, '_id'))
                                            {{Str::remove('_id', $key)}}
                                        @else
                                            {{$key}}
                                        @endif
                                    
                                    </th>
                               
                            @endforeach
                      
                    <th></th>
                </tr>
            </thead>
            <tbody>
            
                
                    @foreach ($data['stockModel']->stock_transfer as $keyStockTransfer => $stockTransfer)
                        
                        <tr>
                           
                            @foreach ($stockTransfer as $key => $stock)
                                <td>
                                    @if ($key == 'date')
                                        {{$stock}}
                                    @elseif($key == Str::contains($key, '_id'))
                                        <a href="{{route(Str::replace('_id', '.edit', $key), $stock)}}" class="uk-button uk-button-danger uk-border-rounded">{{$stock}}</a>
                                    @elseif($key == 'type')
                                        <span uk-icon="{{$iconArray[$stock]}}" class="uk-text-danger"></span>
                                    @else
                                        <input class="uk-input" id="form-stacked-text" type="number" value="{{$stock}}" name="{{$key}}[]">
                                    @endif
                                </td>
                            @endforeach
                            <td>
                                <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockTransfer({{$keyStockTransfer}})"></button>
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
        
            <input name="type" value="0" hidden>
            <input name="user_id" value="{{Auth::user()->user_id}}" hidden>
            <input name="stock_id" value="{{$data['stockModel']->stock_id}}" hidden>
            <input name="date" value="{{Carbon::now()->toDateTimeString()}}" hidden>


            @foreach ($data['stockModel']->stock_transfer as $keyStockTransfer => $stockTransfer)
                        
            
               
                @foreach ($stockTransfer as $key => $stock)
                    <td>
                        @if ($key == 'store_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{Str::upper($key)}}</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="form-stacked-select" name="store_id" name="{{$stock}}">
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
                        @elseif($key == 'stock_id')
                            <div class="uk-margin">
                                <label class="uk-form-label" for="form-stacked-select">{{Str::upper($key)}}</label>
                                <div class="uk-form-controls">
                                    <select class="uk-select" id="form-stacked-select" name="{{$stock}}">
                                        <option value="" selected disabled>SELECT ...</option>
                                    </select>
                                </div>
                            </div>
                        @else
                            @if ($key != 'stock_id' && $key != 'type' && $key != 'user_id' && $key != 'date')
                                <div class="uk-margin">
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                    <div class="uk-form-controls">
                                        <input class="uk-input" id="form-stacked-text" type="number" name="{{$stock}}">
                                    </div>
                                </div>
                            @endif
                        @endif
                        
                    </td>
                @endforeach
               
                @break
        
            @endforeach


           <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
             
        </form>
    </li>
</ul>