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
    
   
    
    if( isset($data['setupList']) ){

        if ( count($data['setupList']['order_setting_key']) == 0 ) {
            $settingModel = new Setting();
            $data['settingModel']->setting_key = $settingModel->setting_key;
        }
    }
 
    
@endphp


@if (count($data['settingModel']->setting_key) > 0)
    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive" id="settingKeyTableID">
        <thead>
            <tr>
                <th></th>
                {{-- <th></th> --}}
                {{-- <th>REF</th> --}}
                @foreach (head($data['settingModel']->setting_key[1]) as $key => $item)
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
                            <div class="uk-inline">
                                <button class="uk-button uk-button-default uk-button-small uk-border-rounded" uk-icon="icon: triangle-down" type="button"></button>
                                <div uk-dropdown="mode: click">
                                    @foreach ( head($setting_key) as $key => $value )
                                        
                                        <div class="uk-margin" @if(in_array($key, $array) == true) hidden @else @endif>
                                            @include('setting.settingKey.partial.tablePartial')
                                        </div>
                                      
                                    @endforeach
                                </div>
                            </div>
                        </td>
                        {{-- <td>
                            <input type="checkbox" id="setting_key[]" name="setting_key[{{$keysetting_key}}][id]" value="{{$keysetting_key}}" onclick="disableElement(this)">
                        </td> --}}
                        {{-- <td>
                            <a class="uk-button uk-button-default" href="">{{$keysetting_key}}</a>
                        </td> --}}
                        @foreach ( head($setting_key) as $key => $value )

                            <td @if(in_array($key, $array) == false) hidden @else @endif>
                                @include('setting.settingKey.partial.tablePartial')
                            </td>
                            
                        @endforeach
                       
                        
                    </tr>
                    
                
            @endforeach
        </tbody>
    </table>
@endif

