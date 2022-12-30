@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Helpers\KeyHelper;

    $route = Str::before(Request::route()->getName(), '.');
    $disabled = 'disabled';
    $array = [];


    if ($route == 'home' || Str::contains($route, 'api')) {
        $array = [
            'image',
            'status',
            'description'
        ];
    }
    
    
@endphp


@if (count($data['settingModel']->setting_key) > 0)
    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive" id="settingKeyTableID">
        <thead>
            <tr>
                <th></th>
                <th>REF</th>
                @foreach (head($data['settingModel']->setting_key) as $key => $item)
                    <th @if(in_array($key, $array)) hidden @else  @endif>{{$key}}</th>
                @endforeach
            </tr>
        </thead>
        
        <tbody>
            @foreach ($data['settingModel']->setting_key  as $keysetting_key => $setting_key)
               {{--  @if (isset($setting_key['setting_key_group']))
                    @if ($setting_key['setting_key_group'] == $setting_key['setting_key_group']) --}}
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
                                            
                                            @foreach (KeyHelper::Type()[$setting_key['setting_key_group']] as $setting_key_type)
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
                  {{--   @endif
                @endif --}}
            @endforeach
        </tbody>
    </table>
@endif
