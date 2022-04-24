@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

    
    <div>
        <div class="uk-card uk-card-default uk-padding">
            <h3>GENERAL</h3>
            
            
                
                @foreach ($data['settingModel']->setting_stock_nutrition as $key => $setting_stock_nutritions)
                    <div class="uk-margin">
                        
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($setting_stock_nutritions)}}</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-stacked-text" type="text">
                        </div>
                       
                    </div>
                @endforeach
                
           
            
            <div class="uk-margin">
                <button class="uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="push"></button>
            </div>
        </div>
    </div>

  
</div>

