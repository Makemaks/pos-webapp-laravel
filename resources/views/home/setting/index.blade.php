@php
    use App\Helpers\KeyHelper;
    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Models\Setting;
 
    
@endphp

@if ( count($data['setting_key']) > 0)
         
    @foreach ( $data['setupList']['setting_key'] as $setting_key_key => $setting_key_item)
        @foreach ($setting_key_item as $setting_key_item_key => $setting_key_item_item)
            <div class="uk-text-small">

                <input id="setting-key-{{$setting_key_key}}" class="uk-checkbox" type="checkbox"  onclick="SettingKey('@isset($stockItem['stock_id']) {{$stockItem['stock_id']}} @endisset', {{$setting_key_item_key}}')">
                
                <label for="setting-key-{{$setting_key_key}}">
                    <span>
                        {{ KeyHelper::Type()[ $setting_key_item_item['setting_key_group'] ][$setting_key_item_item['setting_key_type']] }}
                    </span>
                    <span class="uk-text-bold">{{$setting_key_item_item['value']}}</span>
                </label>
            
            </div>
        @endforeach
    @endforeach

    <div class="uk-margin">
        <button class="uk-button-small uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="trash"></button>
    </div>
      
    
@endif

