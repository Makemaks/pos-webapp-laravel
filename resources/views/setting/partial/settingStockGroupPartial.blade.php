@php
     use App\Models\Setting;
@endphp

<table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
        
    <thead>
        <tr>
            <th></th>
            <th>REF</th>
            @foreach ($data['settingModel']->setting_stock_set as $items)
                @foreach($items as $key => $item)
                    <th>{{$key}}</th>
                @endforeach
                @break
            @endforeach
            <th></th>
        </tr>
    </thead>

    <tbody>
        
    
        @foreach ($data['settingModel']->setting_stock_set  as $keysetting_stock_set => $setting_stock_set)
            @if ($setting_stock_set['type'] == Session::get('type'))
                <tr>
                    <td>
                        <input type="checkbox" name="setting_stock_set_delete[]" value="{{$keysetting_stock_set}}">
                    </td>
                    <td>
                        <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_stock_set}}</button>
                    </td>
                    
                    
                    @foreach ($setting_stock_set as $key => $value)        

                            <td>
                                @if ($key == 'code')
                                    
                                    <input class="uk-input" type="number" name="setting_stock_set[{{$keysetting_stock_set}}][{{$key}}]" value="{{$value}}">
                                @elseif ($key == 'type')
                                                
                                    <select class="uk-select" name="setting_stock_set[{{$keysetting_stock_set}}][{{$key}}]">
                                        <option selected="selected" disabled>SELECT ...</option>
                                    
                                        @foreach (Setting::SettingStockSet() as $key => $setting_group)
                                                
                                            <option @if($key == $setting_stock_set['type']) selected @endif value="{{$key}}">
                                                {{Str::upper($setting_group)}}
                                            </option>
                                                
                                        @endforeach
                                    
                                    </select>
                                @elseif ($key == 'name')
                                    
                                        <textarea class="uk-textarea" name="setting_stock_set[{{$keysetting_stock_set}}][{{$key}}]"> {{$value}}</textarea>
                                
                                @endif
                            </td>
                        
                        

                    @endforeach

                    {{-- <td>
                
                        <div class="uk-width-auto"><a class="uk-button uk-button-default uk-border-rounded" uk-icon="icon: pencil" href="{{route('setting.edit', ['setting' => $data['settingModel']->setting_id,  'index' => $keysetting_stock_set])}}"></a></div>
                    
                    </td> --}}
                </tr>
            
            @endif
        @endforeach
    </tbody>
</table>