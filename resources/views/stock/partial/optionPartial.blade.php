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
                    <h3>OFFERS</h3>
                              
                        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive uk-width-1-2">
                            <thead>
                                <tr>
                                                       

                                    @php
                                        $collection = collect($data['settingModel']->setting_stock_offer[1]);
                                        $collection = $collection->collapse();
                                    @endphp
                                

                                    <th>REF</th>
                                        @foreach ( $collection->except(['exception']) as $key => $item)
                                            
                                                <th>{{$key}}</th>
                                           
                                        @endforeach
                                    
                                    <th>Apply</th>
                                    <th></th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                               
                                
                                    @foreach ($data['settingModel']->setting_stock_offer as $keyStockoffer => $itemStockoffer)
                                
                                            
                                                <tr>
                                                    <td>
                                                        <button class="uk-button uk-button-danger uk-border-rounded">{{$keyStockoffer}}</button>
                                                    </td>
                                                    @foreach ($itemStockoffer as $key => $stock)
                                                    
                                                        @if($key == 'integer' || $key == 'decimal')

                                                            @foreach ($stock as $stockkey => $stockitem)
                                                                @if ($stockkey == 'set_menu')
                                                                    <td>
                                                                        <select class="uk-select" id="form-stacked-select" name="setting_stock_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                                            <option value="" selected disabled>SELECT ...</option>
                                                                            @if ($data['settingModel']->setting_stock_set_menu)
                                                                                @foreach ($data['settingModel']->setting_stock_set_menu  as $key_setting_stock_set_menu  => $item_setting_stock_set_menu)
                                                                                        
                                                                                    <option value="{{$key_setting_stock_set_menu}}" @if($key_setting_stock_set_menu == $stock) selected @endif>
                                                                                        {{$item_setting_stock_set_menu['name']}}
                                                                                    </option>
                                                                                        
                                                                                @endforeach
                                                                            @endif
                                                                            
                                                                        </select>
                                                                    </td>
                                                        
                                                                @else
                                                                    <td><input name="setting_stock_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="number" value="{{$stockitem}}"></td>
                                                                @endif 
                                                            @endforeach
                                                            
                                                        @endif

                                                        
                                                        @if($key == 'default')
                                                            @foreach ($stock as $stockkey => $stockitem)
                                                                    
                                                                @if ($stockkey == 'is_default')
                                                                    <td><input class="uk-radio" type="radio" name="default[setting_stock_offer][{{$key}}]" value="{{$keyStockoffer}}" @if($stock == 0) checked @endif></td>
                                                                
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                        @if($key == 'boolean')
                                                            @foreach ($stock as $stockkey => $stockitem)
                                                           
                                                                @if ($stockkey == 'status')
                                                                
                                                                    <td>
                                                                        <select class="uk-select" id="form-stacked-select" name="setting_stock_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                                            <option value="" selected disabled>SELECT ...</option>
                                                                            @foreach (Stock::OfferStatus()  as $key_stock_offer  => $item_stock_offer)
                                                                                    
                                                                                <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                                                    {{$item_stock_offer}}
                                                                                </option>
                                                                                    
                                                                            @endforeach
                                                                        </select>    
                                                                    </td>

                                                                
                                                                @else
                                                                    <td>
                                                                        <select class="uk-select" id="form-stacked-select" name="setting_stock_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                                            <option value="" selected disabled>SELECT ...</option>
                                                                            @foreach (Stock::OfferType()  as $key_stock_offer  => $item_stock_offer)
                                                                                    
                                                                                <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                                                    {{ Str::upper($item_stock_offer)}}
                                                                                </option>
                                                                                    
                                                                            @endforeach
                                                                        </select>    
                                                                    </td>
                                                                @endif
                                                            @endforeach
                                                        @endif

                                                        @if($key == 'date')
                                                            @foreach ($stock as $stockkey => $stockitem)
                                                                <td><input name="setting_stock_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}"></td>
                                                            @endforeach
                                                        @endif

                                                        @if($key == 'string')
                                                            @foreach ($stock as $stockkey => $stockitem)
                                                                <td><input name="setting_stock_offer[{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}"></td>
                                                            @endforeach
                                                        @endif
                                                       
                                                   
                                                    @endforeach    

                                                    <td>
                                                        @isset($data['stockModel'])
                                                            <input class="uk-radio" type="radio" name="stock_merchandise[stock_offer]" value="{{$keyStockoffer}}" @if($data['stockModel']->stock_merchandise['stock_offer'] == $keyStockoffer) checked @endif>
                                                        @endisset
                                                    </td>
                                                                
                                                    <td>
                                                        <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockoffer({{$keyStockoffer}})"></button>
                                                    </td>    
                                                </tr>
                                            

                                        
                                        

                                    @endforeach

                                
                              
                            </tbody>
                        </table>
                </li>
            
                <li>
            
                    <form action="" class="uk-form-stacked">
                      
                        <h3>OFFERS</h3>
                       
                            @foreach ($data['settingModel']->setting_stock_offer  as $keyStockoffer => $itemStockoffer)
                                @foreach ($itemStockoffer as $key => $stock)
                                                        
                                    @if($key == 'integer' || $key == 'decimal')

                                        @foreach ($stock as $stockkey => $stockitem)
                                            @if ($stockkey == 'set_menu')
                                                <div class ="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                    <select class="uk-select" id="form-stacked-select" name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                        <option value="" selected disabled>SELECT ...</option>
                                                        @if ($data['settingModel']->setting_stock_set_menu)
                                                            @foreach ($data['settingModel']->setting_stock_set_menu  as $key_setting_stock_set_menu  => $item_setting_stock_set_menu)
                                                                    
                                                                <option value="{{$key_setting_stock_set_menu}}" @if($key_setting_stock_set_menu == $stock) selected @endif>
                                                                    {{$item_setting_stock_set_menu['name']}}
                                                                </option>
                                                                    
                                                            @endforeach
                                                        @endif
                                                        
                                                    </select>
                                                </div>
                                    
                                            @else
                                                <div class ="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                    <input name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="number" value="{{$stockitem}}">
                                                </div>
                                            @endif 
                                        @endforeach
                                        
                                    @endif

                                    @if($key == 'boolean')
                                        @foreach ($stock as $stockkey => $stockitem)
                                        
                                            @if ($stockkey == 'status')
                                                            
                                                <div class="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                    <select class="uk-select" id="form-stacked-select" name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                        <option value="" selected disabled>SELECT ...</option>
                                                        @foreach (Stock::OfferStatus()  as $key_stock_offer  => $item_stock_offer)
                                                                
                                                            <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                                {{$item_stock_offer}}
                                                            </option>
                                                                
                                                        @endforeach
                                                    </select>    
                                                </div>

                                            
                                            @else
                                                <div class="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                    <select class="uk-select" id="form-stacked-select" name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]">
                                                        <option value="" selected disabled>SELECT ...</option>
                                                        @foreach (Stock::OfferType()  as $key_stock_offer  => $item_stock_offer)
                                                                
                                                            <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                               {{ Str::upper($item_stock_offer)}}
                                                            </option>
                                                                
                                                        @endforeach
                                                    </select>    
                                                </div>
                                            @endif
                                            
                                        @endforeach
                                    @endif

                                    @if($key == 'date')
                                        @foreach ($stock as $stockkey => $stockitem)
                                            <div class ="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                <input name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}">
                                            </div>
                                        @endforeach
                                    @endif

                                    @if($key == 'string')
                                        @foreach ($stock as $stockkey => $stockitem)
                                           @if ($stockkey == "description")
                                                <div class ="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                    <textarea name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-textarea">{{$stockitem}}</textarea>
                                                </div>
                                           @else
                                                <div class ="uk-margin">
                                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                                    <input name="form[setting_stock_offer][{{$keyStockoffer}}][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}">
                                                </div>
                                           @endif
                                        @endforeach
                                    @endif

                                @endforeach   

                                @break

                            @endforeach
                       
            
                       <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
                         
                    </form>
                </li>
            </ul>
          
           
           
        </div>
    </div>
   
    
  
</div>

