@php
   use App\Models\Stock;
   use App\Helpers\ConfigHelper;
@endphp


<div>
    <div class="uk-card uk-card-default uk-padding">
        <h3>GENERAL</h3>
       
        @foreach ($data['settingModel']->setting_stock_allergen as $key => $setting_stock_allergen)
                @php
                    $checked = "";
                    if (in_array($key, $data['stockModel']->stock_allergen) ) {
                        $checked = 'checked';
                    }
                    
                @endphp
            
            <div class="uk-form-controls">
                <input class="uk-checkbox" type="checkbox" name="stock_allergen[{{$loop->iteration}}]" value="{{$key}}" {{$checked}}>
                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($setting_stock_allergen)}}</label>
            </div>
        @endforeach
        
    </div>
</div>

