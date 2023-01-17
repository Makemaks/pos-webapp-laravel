@php
    use App\Helpers\KeyHelper;
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Models\Setting;
 
@endphp

@if ($setting_key > 0)
   
                
    @foreach ($setting_key as $setting_key_key => $setting_key_item)
        @foreach ($setting_key_item as $setting_key_item_key => $setting_key_item_item)
            <div>

                <input id="setting-key-{{$setting_key_key}}" class="uk-checkbox" type="checkbox"  onclick="SettingKey('@isset($stockItem['stock_id']) {{$stockItem['stock_id']}} @endisset', {{$setting_key_item_key}}')">
                
                <label for="setting-key-{{$setting_key_key}}">
                    <span>
                        {{ KeyHelper::Type()[ $setting_key_item_item['setting_key_group'] ][$setting_key_item_item['setting_key_type']]}}
                    </span>
                    <span class="uk-text-bold uk-margin-left">{{$setting_key_item_item['value']}}</span>
                </label>
            
            </div>
        @endforeach
    @endforeach

    <div class="uk-margin">
        <button class="uk-button-small uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="trash"></button>
    </div>
      
    
@endif

