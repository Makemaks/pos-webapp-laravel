@php
    use App\Models\Setting;
    use App\Helpers\KeyHelper;
@endphp

{{--  <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}"> --}}
<input name="setting_key_id" type="hidden" class="uk-input" value="{{$key}}">

@foreach ( $setting_key as $keyItemSettingKey => $valueItemSettingKey)

    @if ($keyItemSettingKey == 'image')
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-input">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="text" value="{{$valueItemSettingKey}}">
            </div>
        </div>
    @elseif ($keyItemSettingKey == 'setting_key_type')
    
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="form-horizontal-select" name="form[setting_key][{{$keyItemSettingKey}}]" onchange="IndexSetting()">
                
                    @if (head( $data['settingModel']->setting_key )['setting_key_group'] != '')
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach (KeyHelper::Type()[ head( $data['settingModel']->setting_key )['setting_key_group'] ]  as $key_setting_key_type  => $item_setting_key_type)
                                
                            <option value="{{$key_setting_key_type}}" @if($key_setting_key_type == $valueItemSettingKey) selected @endif>
                                {{$item_setting_key_type}}
                            </option>
                        @endforeach
                    @else
                        <option value="0" selected>SELECT ...</option>
                    @endif
                </select>    
            </div>  
                    
        </div>
    @elseif ($keyItemSettingKey == 'setting_key_group')
        
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="form-horizontal-select" name="form[setting_key][{{$keyItemSettingKey}}]" onchange="IndexSetting()">
                
                    <option value="" selected disabled>SELECT ...</option>
                    
                    @foreach (Setting::SettingKeyGroup() as $keySettingKeyGroup =>$valueSettingKeyGroup)
                    
                        <option value="{{$keySettingKeyGroup}}" @if($keySettingKeyGroup == $valueItemSettingKey) selected @endif>
                            {{Str::upper($valueSettingKeyGroup)}}
                        </option>
                            
                    @endforeach
                    
                </select>
            </div>
        </div>
    @elseif ($keyItemSettingKey == 'setting_vat_id')
    
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <select name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-select">
                    <option selected="selected" disabled>SELECT ...</option>
                    @foreach ($data['settingModel']->setting_vat as $setting_vat)
                        <option value="{{$loop->index}}" @if($loop->index == $valueItemSettingKey) selected @endif>
                            {{$setting_vat['name']}}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    
    
    @elseif ($keyItemSettingKey == 'value')
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <input type="number" class="uk-input" name="form[setting_key][{{$keyItemSettingKey}}]" value="{{$valueItemSettingKey}}">
            </div>
        </div>

    @elseif ($keyItemSettingKey == 'description')
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <textarea class="uk-textarea" name="form[setting_key][{{$keyItemSettingKey}}]" rows="1"></textarea>
            </div>
        </div>
    @elseif ($keyItemSettingKey == 'status')
        <div class="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <select class="uk-select" id="form-horizontal-select" name="form[setting_key][{{$keyItemSettingKey}}]">
                
                    @if (head( $data['settingModel']->setting_key )['status'] != '')
                            <option value="" selected disabled>SELECT ...</option>
                        @foreach (Setting::SettingOfferStatus()  as $keySettingOfferStatus  => $valueSettingOfferStatus)
                                
                            <option value="{{$keySettingOfferStatus}}" @if($keySettingOfferStatus == $valueItemSettingKey) selected @endif>
                                {{Str::upper($valueSettingOfferStatus)}}
                            </option>
                                
                        @endforeach
                    @else
                        <option value="0" selected>SELECT ...</option>
                    @endif
                </select>  
            </div>
        </div>
    @else
        <div class ="uk-margin">
            <label class="uk-form-label" for="form-horizontal-select">{{Str::upper($keyItemSettingKey)}}</label>
            <div class="uk-form-controls">
                <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="text" value="{{$valueItemSettingKey}}">
            </div>
        </div>
    @endif 
@endforeach

