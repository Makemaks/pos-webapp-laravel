@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Helpers\KeyHelper;

    $route = Str::before(Request::route()->getName(), '.');
    $disabled = 'disabled';
    $array = [];
    $active = 0;

    if ($route == 'setting-api') {
            $active = 1;
    }
    elseif($route == 'home'){
            $data['settingList'] = new Setting();
            $data['settingModel'] = new Setting();
    }

    if ($route == 'home' || $route == 'setting-api') {
        Session::flash('view', 'Key');
        $array = [
            'image',
            'status',
            'setting_key_group',
            //'description'
        ];
    }
    
    
@endphp

<div>
  
    <ul class="uk-subnav uk-subnav-pill" uk-switcher='active:{{$active}}'>
        <li>
            <a href="#">{{Str::upper(Session::get('view'))}}</a>
        </li>
        <li ><a href="#" uk-icon="plus"></a></li>
    </ul>      

    <ul class="uk-switcher uk-margin">
        <li>
            <form id="settingKeyListID" action="{{route('setting.update', isset($data['settingModel']->setting_id))}}" method="POST">
                @csrf
                @method('PATCH')
                @if ($data['settingList']->first()->setting_key)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive" id="settingKeyTableID">
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach ($data['settingList']->first()->setting_key[1] as $key => $item)
                                    <th @if(in_array($key, $array)) hidden @else  @endif>{{$key}}</th>
                                @endforeach
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($data['settingList']->first()->setting_key  as $keysetting_key => $setting_key)
                                @if (isset($setting_key_group_id))
                                    @if ($setting_key['setting_key_group'] == $setting_key_group_id)
                                        <tr id="tableRowID-{{$keysetting_key}}">
                                            <td>
                                                <input type="checkbox" id="setting_key[]" name="setting_key[{{$keysetting_key}}][id]" value="{{$keysetting_key}}" onclick="disableElement(this)">
                                            </td>
                                            <td>
                                                <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_key}}</button>
                                            </td>
                                            @foreach ($setting_key as $key => $value)

                                                <td @if(in_array($key, $array)) hidden @else @endif>
                                                    
                                                    @if ($key == 'value')
                                                        <input class="uk-input" type="number" name="setting_key[{{$keysetting_key}}][{{$key}}]" value="{{$value}}" {{$disabled}}>
                                                    @elseif ($key == 'setting_key_type')
                                                                    
                                                        <select class="uk-select" name="setting_key[{{$keysetting_key}}][{{$key}}]" {{$disabled}}>
                                                           
                                                            @foreach (KeyHelper::Type()[$setting_key_group_id] as $setting_key_type)
                                                                <option @if($loop->index == $value) selected @endif value="{{$loop->index}}">
                                                                    {{Str::upper($setting_key_type)}}
                                                                </option>
                                                            @endforeach
                                                        
                                                        </select>
                                                        
                                                    @elseif ($key == 'description')
                                                        
                                                            <textarea class="uk-textarea" name="setting_key[{{$keysetting_key}}][{{$key}}]" rows="1" {{$disabled}}>{{$value}}</textarea>

                                                    @elseif ($key == 'status')
                                                        <select class="uk-select" id="form-stacked-select" name="setting_key[{{$keysetting_key}}][{{$key}}]" {{$disabled}}>
                                                            <option value="" selected disabled>SELECT ...</option>
                                                            @foreach (Setting::SettingOfferStatus()  as $keySettingOfferStatus  => $valueSettingOfferStatus)
                                                                    
                                                                <option value="{{$keySettingOfferStatus}}" @if($keySettingOfferStatus == $value) selected @endif>
                                                                    {{$valueSettingOfferStatus}}
                                                                </option>
                                                                    
                                                            @endforeach
                                                            
                                                        </select>    
                                                   
                                                    @elseif ($key == 'setting_key_group')
                                                        <select class="uk-select" id="form-stacked-select" name="setting_key[{{$keysetting_key}}][{{$key}}]" {{$disabled}}>
                                                            {{-- <option selected disabled>SELECT ...</option> --}}
                                                            @foreach (Setting::SettingKeyGroup() as $setting_key_group)
                                                                <option value="{{$loop->index}}" @if($loop->index == $value) selected @endif>
                                                                    {{Str::upper($setting_key_group)}}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    
                                                    @elseif ($key == 'image')
                                                        <input class="uk-input" type="text" value="{{$value}}" name="setting_key[{{$keysetting_key}}][{{$key}}]" {{$disabled}}>
                                                    @else
                                                        <input class="uk-input" type="text" placeholder="Input" value="{{$value}}" name="setting_key[{{$keysetting_key}}][{{$key}}]" {{$disabled}}>
                                                    @endif
                                                    
                                                </td>

                                            @endforeach
                                        </tr>
                                    @endif
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </form>
        </li>

        <li>
            <form action="{{ route('setting.store') }}" method="POST" class="uk-form-stacked" id="settingKeyFormID">
                @csrf
              
                <div>
                    @foreach ($data['settingModel']->setting_key  as $keySettingKey => $itemSettingKey)


                        @foreach ($itemSettingKey as $keyItemSettingKey => $valueItemSettingKey)
                     

                            @if ($keyItemSettingKey == 'image')
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                                <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="text" value="">
                            @elseif ($keyItemSettingKey == 'setting_key_type')
                          
                                <div class ="uk-margin">
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($keyItemSettingKey)}}</label>
                                    <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$keyItemSettingKey}}]">
                                       
                                            @if (collect($data['settingModel']->setting_key)->first()['setting_key_group'] != '')
                                                <option value="" selected disabled>SELECT ...</option>
                                                @foreach (KeyHelper::Type()[ collect($data['settingModel']->setting_key)->first()['setting_key_group'] ]  as $key_setting_key_type  => $item_setting_key_type)
                                                        
                                                    <option value="{{$key_setting_key_type}}" @if($key_setting_key_type == $valueItemSettingKey) selected @endif>
                                                        {{$item_setting_key_type}}
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
                                    <input name="form[setting_key][{{$keyItemSettingKey}}]" class="uk-input" type="text" value="">
                                </div>
                            @endif 
                        @endforeach
                        @break
                    @endforeach
                    <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
                </div>
            
                @if ($route != 'home' && $route != 'setting-api')
                    <div class="uk-child-width-expand@m" uk-grid>
                        <div>
                            <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" type="submit">
                                SAVE
                            </button>
                        </div>     
                    </div>
                @endif
            </form>
        </li>
    </ul>
</div>
