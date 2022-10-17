@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
   $route = Str::before(Request::route()->getName(), '.');
  
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2@xl" uk-grid>

    <div>
        <div class="uk-card uk-card-default uk-padding">
       
            <ul class="uk-subnav uk-subnav-pill" uk-switcher="{{$active}}">
                <li><a href="#" uk-icon="list"></a></li>
                <li><a href="#" uk-icon="plus"></a></li>
            </ul>
            
            <ul class="uk-switcher uk-margin">
                <li>
                    <h3>NUTRITION</h3>
                              
                        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>REF</th>
                                    
                                        @foreach (collect($data['stockModel']->stock_nutrition)->first() as $key => $item)
                                            <th>{{$key}}</th>
                                        @endforeach
                                   
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                             
                                    @foreach ($data['stockModel']->stock_nutrition as $keyStock => $itemStock)
                                        
                                          
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="setting_stock_nutrition[]" value="{{$keyStock}}">
                                            </td>
                                            <td>
                                                <button class="uk-button uk-button-default uk-border-rounded">{{$keyStock}}</button>
                                            </td>
                                                @foreach ($itemStock as $keyItemStock => $itemItemStock)
                                                   
                                                    <td>

                                                        @if($keyItemStock == 'setting_stock_id')
                                                            <select class="uk-select" name="stock_nutrition[{{$keyItemStock}}][{{$keyStock}}]">
                                                                <option selected disabled>SELECT ...</option>
                                                                @foreach ($data['settingModel']->setting_stock_nutrition as $key_setting_stock_nutrition => $item)
                                                                    <option value="{{$key_setting_stock_nutrition}}" @if($key_setting_stock_nutrition == $itemItemStock) selected @endif>{{$item}}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif($keyItemStock == 'value')
                                                            <input name="stock_nutrition[{{$key}}][{{$keyStock}}]" class="uk-input" type="number" value="{{$itemItemStock}}">
                                                        
                                                        @else
                                                           <input name="stock_nutrition[{{$key}}][{{$keyStock}}]" class="uk-input" type="text" value="{{$itemItemStock}}">
                                                        @endif
                                                    </td>
                                                    
                                            
                                            @endforeach
                                        </tr>
                                    
                                    @endforeach
                                
                              
                            </tbody>
                        </table>
                </li>
            
                <li>
                    @if ($route != 'menu')
                        <div>
                        
                            <h3>NUTRITION</h3>
                            
                            @php
                                $data['stockModel'] = new Stock();
                            @endphp

                                @foreach ($data['stockModel']->stock_nutrition  as $stock_nutrition_key => $stock_nutrition)
                                    
    
                                        
                                        @if ($stock_nutrition_key == 'value')
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stock_nutrition_key)}}</label>
                                                <input class="uk-input" type="number" value="" name="form[stock_nutrition]{{$stock_nutrition}}">
                                            </div>
                                        @elseif($stock_nutrition_key == 'setting_stock_id')
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stock_nutrition_key)}}</label>
                                                <select class="uk-select" name="form[stock_nutrition]{{$stock_nutrition}}" id="">
                                                    <option selected disabled>SELECT...</option>
                                                    @foreach ($data['settingModel']->setting_stock_nutrition as $item)
                                                            <option value="">{{$item}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @else
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stock_nutrition_key)}}</label>
                                                <input class="uk-input" type="text" value="" name="form[stock_nutrition]{{$stock_nutrition}}">
                                            </div>
                                        @endif
                                            
                                            
                                    
                                    

                                @endforeach
                        
                
                                <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push"></button>
                            
                        </div>
                    @endif
                </li>
            </ul>
          
        </div>
    </div>
   
    


  
</div>

{{-- @foreach (ConfigHelper::Nutrition() as $key => $stock_nutrition)
                   
    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stock_nutrition['name'])}}</label>
        <div class="uk-form-controls">
            <input class="uk-checkbox" type="checkbox">
        </div>
        
    </div>
@endforeach --}}

