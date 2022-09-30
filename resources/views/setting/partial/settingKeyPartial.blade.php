@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
@endphp

<form action="{{ route('setting.store') }}" method="POST">
    @csrf
    <div class="uk-child-width-1-2" uk-grid>
        @foreach ($data['settingModel']->setting_key  as $keySettingKey => $itemSettingKey)
            @foreach ($itemSettingKey as $keyItemSettingKey => $valueItemSettingKey)
                @if ($keyItemSettingKey == 'type')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$key}}][{{$keyItemSettingKey}}]">
                            <option value="" selected disabled>SELECT ...</option>
                            @if ($data['settingModel']->setting_stock_set_menu)
                                @foreach ($data['settingModel']->setting_stock_set_menu  as $key_setting_stock_set_menu  => $item_setting_stock_set_menu)
                                        
                                    <option value="{{$key_setting_stock_set_menu}}" @if($key_setting_stock_set_menu == $stock) selected @endif>
                                        {{$item_setting_stock_set_menu['name']}}
                                    </option>
                                        
                                @endforeach
                            @endif
                        </select>
                    </div>
                @elseif ($keyItemSettingKey == 'setting_key_type')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]">
                            <option value="" selected disabled>SELECT ...</option>
                            @if ($data['settingModel']->setting_key_type)
                                @foreach ($data['settingModel']->setting_key_type  as $key_setting_key_type  => $item_setting_key_type)
                                        
                                    <option value="{{$key_setting_key_type}}" @if($key_setting_key_type == $valueItemSettingKey) selected @endif>
                                        {{$item_setting_key_type}}
                                    </option>
                                        
                                @endforeach
                            @endif
                        </select>
                    </div>
                @elseif ($keyItemSettingKey == 'group')
                    {{-- {{dd($valueItemSettingKey)}} --}}
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]">
                            <option value="" selected disabled>SELECT ...</option>
                            @if ($data['settingModel']->setting_key_type)
                                @foreach (Setting::SettingKeyGroup() as $keySettingKeyGroup =>$valueSettingKeyGroup)
                                        
                                    <option value="{{$keySettingKeyGroup}}" @if($keySettingKeyGroup == Session::get('group')) selected @endif>
                                        {{$valueSettingKeyGroup}}
                                    </option>
                                        
                                @endforeach
                            @endif
                        </select>
                    </div>
                @elseif ($keyItemSettingKey == 'value')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <input type="number" class="uk-input" name="form[setting_key][{{$keyItemSettingKey}}]">
                    </div>

                @elseif ($keyItemSettingKey == 'description')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <textarea class="uk-textarea" name="form[setting_key][{{$keyItemSettingKey}}]"></textarea>
                    </div>
                @elseif ($keyItemSettingKey == 'status')
                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]">
                            <option value="" selected disabled>SELECT ...</option>
                            @foreach (Setting::SettingOfferStatus()  as $keySettingOfferStatus  => $valueSettingOfferStatus)
                                    
                                <option value="{{$keySettingOfferStatus}}" @if($keySettingOfferStatus == $valueItemSettingKey) selected @endif>
                                    {{$valueSettingOfferStatus}}
                                </option>
                                    
                            @endforeach
                        </select>  
                    </div>
                @else
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                        <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="number" value="">
                    </div>
                @endif 
            @endforeach
            @break
        @endforeach
        <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
    </div>

    <div class="uk-child-width-expand@m" uk-grid>
        <div>
            <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" type="submit">
                SAVE
            </button>
        </div>     
    </div>
</form>

@if (Session::get('setting_finalise_key') == 'cash')

    @php
        $setting_key_type = collect($data['settingModel']->setting_key)->where('setting_key_type', 1);
    @endphp


        <div class="uk-child-width-1-2 uk-grid-match" uk-grid>
            @foreach ($setting_key_type as $keySettingKey => $itemSettingKey)
              
                <div onclick="useSettingFinaliseKey({{$itemSettingKey['setting_key_type']}}, {{$keySettingKey}})">
                    
                    <label class="uk-text-center">
                        <div class="uk-padding uk-light" style="background-color: #{{StringHelper::getColor()}}">
                            {{$itemSettingKey['value']}}
                            <p>{{$itemSettingKey['description']}}</p>
                        </div>
                    </label>
                   
                  
                        @php
                            $setupList = Session::get('user-session-'.Auth::user()->user_id.'.'.'setupList');
                        @endphp

                        @foreach ($setupList['order_finalise_key'] as $key => $value)
                            @if ($value['key'] == $keySettingKey && $value['type'] == $itemSettingKey['setting_key_type'])

                                <button class="uk-margin uk-button uk-button-danger" type="button">Remove</button>
                                
                            @endif
                        @endforeach
                

                </div>
    
            @endforeach
        </div>

    
@endif
