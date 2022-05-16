<div>
                            
    <h3>CATEGORY</h3>
    @if ($data['settingModel']->setting_stock_group)
        @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
            @foreach ($setting_stock_group as $key =>$item)
               @if ($key == 'plu')
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                        <select class="uk-select" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">
                            <option selected="selected" disabled>SELECT ...</option>
                           
                            @foreach ($data['settingModel']->setting_stock_group as $key => $setting_stock_plu)
                                                
                                    <option value="{{$key}}">{{$setting_stock_plu['description']}}</option>
                            @endforeach
                           
                        </select>
                    </div>
                @elseif ($key == 'offer_id')
                                
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                        <select class="uk-select" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">
                            <option selected="selected" disabled>SELECT ...</option>
                        
                            @foreach ($data['settingModel']->setting_stock_offer as $key => $setting_stock_offer)
                                    
                                  <option value="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">{{$setting_stock_offer['string']['description']}}</option>
                                    
                            @endforeach
                        
                        </select>
                    </div>
                @else
                    @if ($key != 'default')
                        <div class="uk-margin">
                            <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                            <input class="uk-input" type="number" value="" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">
                        </div>
                    @endif
               @endif

            @endforeach

            @break

        @endforeach
    @endif

     
</div>