@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

   
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
                                        @if ($data['stockModel']->stock_web)
                                            @foreach ($data['stockModel']->stock_web[1] as $key => $item)
                                                <th>{{$key}}</th>
                                            @endforeach
                                        @endif
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                    @if ($data['stockModel']->stock_web)
                                        @foreach ($data['stockModel']->stock_web as $keyStockweb => $stockweb)
                                            <tr>
                                                
                                                @foreach ($stockweb as $key => $stock)
                                                    <td>
                                                        @if ($key == 'plu')
                                                        
                                                            <select class="uk-select" name="stock_web_id">
                                                                <option selected="selected" disabled>SELECT ...</option>
                                                            
                                                                @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $setting_stock_plu)
                                                                        
                                                                        <option value="{{$key}}" >{{$setting_stock_plu['descriptor']}}</option>
                                                                @endforeach
                                                            
                                                            </select>
                                                        @else
                                                                <input name="{{$key}}[]" class="uk-input" type="number" value="{{$stock}}">
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
                                @foreach ($data['stockModel']->stock_web  as $stock_web_key => $stock_web)
                                    @foreach ($stock_web as $key =>$item)
                                       @if ($key == 'plu')
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                                <select class="uk-select" name="stock_web_id">
                                                    <option selected="selected" disabled>SELECT ...</option>
                                                   
                                                    @foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $setting_stock_plu)
                                                                        
                                                            <option value="{{$key}}" >{{$setting_stock_plu['descriptor']}}</option>
                                                    @endforeach
                                                   
                                                </select>
                                            </div>
                                        @else
                                            <div class="uk-margin">
                                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                                                <input class="uk-input" type="number" value="" name="{{$key}}">
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

