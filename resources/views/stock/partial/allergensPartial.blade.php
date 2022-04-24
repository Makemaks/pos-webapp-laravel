@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div class="uk-grid-match uk-grid-small uk-child-width-1-2" uk-grid>

   
    <div>
        <div class="uk-card uk-card-default uk-padding">
            <h3>GENERAL</h3>
            
            <div uk-grid>
                
                @foreach (ConfigHelper::Allergen() as $key => $setting_stock_allergen)
                    <div>
                        @php
                            if(){
                                
                            }
                        @endphp
                        
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($setting_stock_allergen)}}</label>
                        <div class="uk-form-controls">
                            <input class="uk-checkbox" type="checkbox">
                        </div>
                       
                    </div>
                @endforeach
                
            </div>
            
        </div>
    </div>

   
  
</div>

