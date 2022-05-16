@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2@xl" uk-grid>

   
        <div>
            <div class="uk-card uk-card-default uk-padding">
                <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                    <li><a href="#" uk-icon="list"></a></li>
                    <li><a href="#" uk-icon="plus"></a></li>
                </ul>
                
                <ul class="uk-switcher uk-margin">
                    <li>
                        <h3>GENERAL</h3>
                
                            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                                <thead>
                                    <tr>
                                        <th>REF</th>
                                        @foreach ($data['stockModel']->stock_web[1] as $key => $item)
                                            <th>{{$key}}</th>
                                        @endforeach
                                        
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @if ($data['stockModel']->stock_web)
                                        @foreach ($data['stockModel']->stock_web as $keyStockweb => $stockweb)
                                            <tr>
                                                <td>
                                                    <button class="uk-button uk-button-danger uk-border-rounded">{{$keyStockweb}}</button>
                                                </td>
                                                @foreach ($stockweb as $key => $stock)
                                                    <td>
                                                        @if ($key == 'plu')
                                                        
                                                            <select class="uk-select" name="stock_web[{{$keyStockweb}}][{{$key}}]">
                                                                <option selected disabled>SELECT ...</option>
                                                            
                                                                @foreach ($data['settingModel']->setting_stock_group as $keyPLU => $setting_stock_plu)
                                                                        @if ($setting_stock_plu['type'] == '2')
                                                                            <option value="{{$stock}}" @if($stock == $keyPLU) selected @endif>{{$setting_stock_plu['description']}}</option>
                                                                        @endif
                                                                        
                                                                @endforeach
                                                            </select>

                                                        @elseif ($key == 'offer_id')
                                                        
                                                            <select class="uk-select" name="stock_web[{{$keyStockweb}}][{{$key}}]">
                                                                <option selected="selected" disabled>SELECT ...</option>
                                                            
                                                                @foreach ($data['settingModel']->setting_stock_offer as $keyOffer => $setting_stock_offer)
                                                                     <option value="{{$stock}}" @if($stock == $keyOffer) selected @endif>{{$setting_stock_offer['string']['description']}}</option>
                                                                @endforeach
                                                            
                                                            </select>
                                                        @elseif($key == 'default')
                                                           
                                                            <input name="default[stock_web][{{$key}}]" class="uk-radio" type="radio" value="{{$keyStockweb}}" @if($stock == 0) checked @endif>
                                                        @else
                                                                @if ($key != 'offer_id' || $key != 'price')
                                                                    <input name="stock_web[{{$keyStockweb}}][{{$key}}]" class="uk-input" type="number" value="{{$stock}}">
                                                                @endif
                                                        @endif
                                                    </td>
                                                    
                                                @endforeach
                
                                            
                
                                                <td>
                                                    <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockweb({{$stock}})"></button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                
                                </tbody>
                            </table>
                        </li>
                
                    <li>
                
                        <form action="" class="uk-form-stacked">
                            
                            <h3>GENERAL</h3>
                            @if ($data['stockModel']->stock_web)
                                @foreach ($data['stockModel']->stock_web  as $keyStockweb => $stock_web)
                                    @foreach ($stock_web as $key =>$item)
                                       @if ($key == 'plu')
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                                <select class="uk-select" name="stock_web[{{$keyStockweb}}][{{$key}}]">
                                                    <option selected="selected" disabled>SELECT ...</option>
                                                   
                                                    @foreach ($data['settingModel']->setting_stock_group as $key => $setting_stock_plu)
                                                                        
                                                            <option value="{{$key}}">{{$setting_stock_plu['description']}}</option>
                                                    @endforeach
                                                   
                                                </select>
                                            </div>
                                        @elseif ($key == 'offer_id')
                                                        
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                                <select class="uk-select" name="stock_web[{{$keyStockweb}}][{{$key}}]">
                                                    <option selected="selected" disabled>SELECT ...</option>
                                                
                                                    @foreach ($data['settingModel']->setting_stock_offer as $key => $setting_stock_offer)
                                                            
                                                          <option value="stock_web[{{$keyStockweb}}][{{$key}}]">{{$setting_stock_offer['string']['description']}}</option>
                                                            
                                                    @endforeach
                                                
                                                </select>
                                            </div>
                                        @else
                                            @if ($key != 'default')
                                                <div class="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                                    <input class="uk-input" type="number" value="" name="stock_web[{{$keyStockweb}}][{{$key}}]">
                                                </div>
                                            @endif
                                       @endif

                                    @endforeach
    
                                    @break
    
                                @endforeach
                            @endif
                
                           <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
                             
                        </form>
                    </li>
                </ul>
              
                
            </div>
        </div>
   
  
</div>

