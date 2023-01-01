@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Helpers\KeyHelper;

    
@endphp

@if ($key == 'value')
    <input class="uk-input" type="number" name="setting_key[{{$key}}][{{$loop->iteration}}]" value="{{$value}}" {{$disabled}}>
@elseif ($key == 'setting_key_type')
                
    
    <select class="uk-select" name="setting_key[{{$key}}][{{$loop->iteration}}]" {{$disabled}}>
        @if (head( $data['settingModel']->setting_key[1] )['setting_key_group'] != '')  

            @php
                $setting_key_group = head( $data['settingModel']->setting_key[1] )['setting_key_group'];
            @endphp

            @foreach (KeyHelper::Type()[ $setting_key_group ] as $setting_key_type_key => $setting_key_type)
                <option @if($setting_key_type_key == $value) selected @endif value="{{$setting_key_type_key}}">
                    {{Str::upper($setting_key_type)}}
                </option>
            @endforeach
        @else
            <option value="0" selected>SELECT ...</option>
        @endif
    
    </select>
    
@elseif ($key == 'description')
    
        <textarea class="uk-textarea" name="setting_key[{{$key}}][{{$loop->iteration}}]" rows="1" {{$disabled}}>{{$value}}</textarea>

@elseif ($key == 'status')
    <select class="uk-select" id="form-stacked-select" name="setting_key[{{$key}}][{{$loop->iteration}}]" {{$disabled}}>
        
        @if (head( $data['settingModel']->setting_key[1] )['setting_key_group'] != '')
            @foreach (Setting::SettingOfferStatus()  as $keySettingOfferStatus  => $valueSettingOfferStatus)
                <option value="{{$keySettingOfferStatus}}" @if($keySettingOfferStatus == $value) selected @endif>
                    {{$valueSettingOfferStatus}}
                </option>
            @endforeach
        @else
            <option value="0" selected>SELECT ...</option>
        @endif

    </select>    

@elseif ($key == 'setting_key_group')
    <select class="uk-select" id="form-stacked-select" name="setting_key[{{$key}}][{{$loop->iteration}}]" {{$disabled}}>
        
        @if (head( $data['settingModel']->setting_key[1] )['setting_key_group'] != '')
            @foreach (Setting::SettingKeyGroup() as $setting_key_group_key => $setting_key_group)
                <option value="{{$setting_key_group_key}}" @if($setting_key_group_key == $value) selected @endif>
                    {{Str::upper($setting_key_group)}}
                </option>
            @endforeach
        @else
            <option value="0" selected>SELECT ...</option>
        @endif
        
    </select>

@elseif ($key == 'image')
    <input class="uk-input" type="text" value="{{$value}}" name="setting_key[{{$key}}][{{$loop->iteration}}]" {{$disabled}}>
@else
    <input class="uk-input" type="text" placeholder="Input" value="{{$value}}" name="setting_key[{{$key}}][{{$loop->iteration}}]" {{$disabled}}>
@endif