@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Helpers\KeyHelper;

    $route = Str::before(Request::route()->getName(), '.');
@endphp


<div>
    
    @foreach ($data['settingModel']->setting_key  as $keySettingKey => $itemSettingKey)

        <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
        <input name="setting_key_id" class="uk-input" type="hidden" value="{{$keySettingKey}}">

        @foreach ($itemSettingKey as $keyItemSettingKey => $valueItemSettingKey)
        

            @if ($keyItemSettingKey == 'image')
                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="text" value="{{$valueItemSettingKey}}">
            @elseif ($keyItemSettingKey == 'setting_key_type')
            
                <div class ="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                    <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]" onchange="IndexSetting(this,'setting_key_type')">
                        
                            @if (collect($data['settingModel']->setting_key)->first()['setting_key_group'] != '')
                                <option value="" selected disabled>SELECT ...</option>
                                @foreach (KeyHelper::Type()[ collect($data['settingModel']->setting_key)->first()['setting_key_group'] ]  as $key_setting_key  => $item_setting_key)
                                        
                                    <option value="{{$key_setting_key}}" @if($key_setting_key == $valueItemSettingKey) selected @endif>
                                        {{$item_setting_key}}
                                    </option>
                                        
                                @endforeach
                            @else
                                <option value="0" selected>SELECT ...</option>
                            @endif
                    </select>
                            
                            
                </div>
            @elseif ($keyItemSettingKey == 'setting_key_group')
                
                <div class ="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                    <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]" onchange="IndexSetting(this,'setting_key_group')">
                        <option value="" selected disabled>SELECT ...</option>
                            
                            @foreach (Setting::SettingKeyGroup() as $keySettingKeyGroup =>$valueSettingKeyGroup)
                            
                                <option value="{{$keySettingKeyGroup}}" @if($keySettingKeyGroup == $valueItemSettingKey) selected @endif>
                                    {{Str::upper($valueSettingKeyGroup)}}
                                </option>
                                    
                            @endforeach
                            
                    </select>
                </div>
            
            @elseif ($keyItemSettingKey == 'value')
                <div class ="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                    <input type="number" class="uk-input" name="form[setting_key][{{$keyItemSettingKey}}]" value="{{$valueItemSettingKey}}">
                </div>

            @elseif ($keyItemSettingKey == 'description')
                <div class ="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                    <textarea class="uk-textarea" name="form[setting_key][{{$keyItemSettingKey}}]" rows="1"></textarea>
                </div>
            @elseif ($keyItemSettingKey == 'status')
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                    <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]">
                        
                        @if (collect($data['settingModel']->setting_key)->first()['status'] != '')
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
            @else
                <div class ="uk-margin">
                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                    <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="text" value="{{$valueItemSettingKey}}">
                </div>
            @endif 
        @endforeach
        @break
    @endforeach


    
    <div class="uk-margin-small">
        @if ($route != 'home' && Str::contains($route,'api'))
            <button type="submit" class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger">
                SAVE
            </button>
        @else
            <button type="button" class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" onclick="StoreSettingKey()">
                SAVE
            </button>
        @endif
    </div>
</div>
