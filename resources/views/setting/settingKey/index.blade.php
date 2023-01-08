@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Helpers\KeyHelper;

    $route = Str::before(Request::route()->getName(), '.');
    $disabled = 'disabled';
    $array = [];


    if ($route == 'home' || Str::contains($route, 'api')) {
        $array = [
            'name',
            'value',
        ];
    }else{
        $disabled = '';
    }
    
   
    
    /* if( isset($data['setupList']) ){

        if ( count($data['setupList']['order_setting_key']) == 0 ) {
            $settingModel = new Setting();
            $data['settingModel']->setting_key = $settingModel->setting_key;
        }
    } */
 
    
@endphp

<form id="settingKeyListID" action="{{route('setting.update', isset($data['settingModel']->setting_id))}}" method="POST">
    @csrf
    @method('PATCH')

    @if (count($data['settingModel']->setting_key) > 0)
        <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>REF</th>

                    @foreach (head($data['settingModel']->setting_key) as $key => $item)
                        <th @if(in_array($key, $array) == false) hidden @else  @endif>
                            {{Str::afterLast($key, '_')}}
                        </th>
                    @endforeach
                    
                </tr>
            </thead>
            
            <tbody>
                @foreach ($data['settingModel']->setting_key as $setting_key)
                    
                        <tr id="tableRowID-{{$loop->iteration}}">
                        
                            <td>
                                <input type="checkbox" id="setting_key[]" name="setting_key[{{$loop->iteration}}][id]" value="{{$key}}" onclick="disableElement(this)">
                            </td>

                            <td>
                                <a class="uk-button uk-button-default uk-border-rounded" href="">{{$loop->iteration}}</a>
                            </td>
                            
                            @foreach ( $setting_key as $setting_key_key => $setting_key_value )
                        
                                @foreach ($setting_key_value as $key => $value)

                                        <td @if(in_array($key, $array) == false) hidden @endif>
                                                    
                                                                            
                                            @if ($key == 'value')
                                                <input class="uk-input" type="number" name="setting_key[{{$key}}][{{$loop->iteration}}]" value="{{$value}}" {{$disabled}}>
                                            @elseif ($key == 'setting_key_type')
                                                        
                                                <select class="uk-select" name="setting_key[{{$key}}][{{$loop->iteration}}]" {{$disabled}}>
                                                    @if ( $value != '' )  

                                                        @foreach (KeyHelper::Type()[ head( $data['settingModel']->setting_key[1])['setting_key_group'] ] as $setting_key_type_key => $setting_key_type)
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
                                                    
                                                    @if ( $value != '' )
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
                                                    
                                                    @if ( $value != '' )
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
                                        </td>

                                @endforeach
                                
                            @endforeach
                        
                            
                        </tr>
                        
                    
                @endforeach
            </tbody>
        </table>
    @endif

</form>

