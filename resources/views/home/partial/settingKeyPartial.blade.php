@php
    use App\Helpers\KeyHelper;
@endphp

@if (count($setting_key) > 0)
    <div class="uk-inline">
        <button uk-icon="triangle-right" type="button"></button>
        <div uk-dropdown="mode: click; pos: right-top" class="uk-overflow-auto uk-height-medium">
            
            {{-- @include('setting.settingKey.partial.tablePartial') --}}
            @foreach ($setting_key as $setting_key_key => $setting_key_item)
                @foreach ($setting_key_item as $setting_key_item_key => $setting_key_item_item)
                    <div>
                        <span>
                            {{ KeyHelper::Type()[ $setting_key_item_item['setting_key_group'] ][$setting_key_item_item['setting_key_type']]}}
                        </span>
                        
                        <span class="uk-text-bold uk-margin-left">{{$setting_key_item_item['value']}}</span>
                        <span>
                            <button class="uk-button-small uk-button uk-button-danger uk-border-rounded uk-width-expand" uk-icon="trash" onclick="SettingKey('@isset($stockItem['stock_id']) {{$stockItem['stock_id']}} @endisset', {{$setting_key_item_key}}')"></button>
                        </span>
                    </div>
                    <hr>
                @endforeach
            @endforeach
        </div>
    </div>
@endif

