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
                    <h3>NUTRITION</h3>
                              
                        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                            <thead>
                                <tr>
                                    @if ($data['stockModel']->stock_nutrition)
                                        @foreach (ConfigHelper::Nutrition()[0] as $key => $item)
                                            <th>{{$key}}</th>
                                        @endforeach
                                    @endif
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                               
                                @if ($data['stockModel']->stock_nutrition)
                                    @foreach ($data['settingModel']->setting_stock_nutrition as $key => $stock_nutrition)
                                        @if (in_array($key, $data['stockModel']->stock_nutrition))
                                            <tr>
                                                @foreach ($stock_nutrition as $keyStock => $stock)
                                                
                                                
                                                        <td>
                                                            @if($keyStock == 'value')
                                                                <input name="stock_nutrition[{{$key}}][{{$keyStock}}]" class="uk-input" type="number" value="{{$stock}}">
                                                            
                                                            @else
                                                                <input name="stock_nutrition[{{$key}}][{{$keyStock}}]" class="uk-input" type="text" value="{{$stock}}">
                                                            @endif
                                                        </td>
                                                        
                                                
                                                @endforeach
                                                <td>
                                                    <button class="uk-button uk-button-danger uk-border-rounded" uk-icon="trash" onclick="deleteStockoffers({{$key}})"></button>
                                                </td>
                                            </tr>

                                        @endif
                                    @endforeach
                                    

                                @endif
                              
                            </tbody>
                        </table>
                </li>
            
                <li>
            
                    <form action="" class="uk-form-stacked">
                      
                        <h3>OFFERS</h3>
                        @if ($data['stockModel']->stock_nutrition)
                            @foreach ($data['settingModel']->setting_stock_nutrition  as $stock_nutrition_key => $stock_nutrition)
                                @foreach ($stock_nutrition as $key =>$item)
                                   @if ($key == 'value')
                                        <div class="uk-margin">
                                            <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                            <input class="uk-input" type="number" value="" name="stock_nutrition[{{$stock_nutrition_key}}]{{$key}}">
                                        </div>
                                    @else
                                        <div class="uk-margin">
                                            <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                            <input class="uk-input" type="text" value="" name="stock_nutrition[{{$stock_nutrition_key}}]{{$key}}">
                                        </div>
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

{{-- @foreach (ConfigHelper::Nutrition() as $key => $stock_nutrition)
                   
    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stock_nutrition['name'])}}</label>
        <div class="uk-form-controls">
            <input class="uk-checkbox" type="checkbox">
        </div>
        
    </div>
@endforeach --}}

