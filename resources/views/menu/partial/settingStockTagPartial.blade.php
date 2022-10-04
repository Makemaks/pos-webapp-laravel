@php
    use App\Models\Setting;
@endphp


@if ($data['settingModel']->edit == false)
    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
        Save
    </button>
@endif

<button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingDelete" name="settingDelete">
    Delete
</button>

<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li>
       
        <a href="#">
            @if ($data['settingModel']->edit == false)
                {{Str::upper(Session::get('view'))}}
            @endif
        </a>
       
    </li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>
        
        <form id="settingUpdate" action="{{route('setting.update', $data['settingModel']->setting_id)}}" method="POST">
            @csrf
            @method('PATCH')
            <div>                 
          
                @if ($data['settingModel']->setting_stock_tag)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach (Arr::first($data['settingModel']->setting_stock_tag) as $key => $item)
                                    <th>{{$key}}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            
                           
                            @foreach ($data['settingModel']->setting_stock_tag  as $keysetting_stock_tag => $setting_stock_tag)
                                {{-- @if ($setting_stock_tag['type'] == Session::get('type')) --}}
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_stock_tag_delete[]" value="{{$keysetting_stock_tag}}">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_stock_tag}}</button>
                                        </td>
                                        
                                        @foreach ($setting_stock_tag as $key => $value)        
                                            <td>
                                                @if ($key == 'tag')
                                                    <input class="uk-input" type="text" name="setting_stock_tag[{{$keysetting_stock_tag}}][{{$key}}]" value="{{$value}}">
                                                @elseif ($key == 'setting_stock_tag_group_id')
                                                                
                                                    <select class="uk-select" name="setting_stock_tag[{{$keysetting_stock_tag}}][{{$key}}]">
                                                        <option selected="selected" disabled>SELECT ...</option>

                                                        @foreach($data['settingModel']->setting_stock_tag_group as $key_setting_stock_tag_group => $item_setting_stock_tag_group)
                                                            <option {{$key_setting_stock_tag_group == $value ? 'selected' : ''}} value="{{$key_setting_stock_tag_group}}">
                                                                {{$item_setting_stock_tag_group['name']}}
                                                            </option>
                                                        @endforeach

                                                        {{-- @foreach ($data['settingModel']->setting_stock_group  as $key_setting_stock_group  => $item_setting_stock_group)
                                                            @foreach (Setting::SettingStockGroup() as $key => $setting_group)
                                                                @if($key == $item_setting_stock_group['type'])                             
                                                                    <option {{$key_setting_stock_group == $setting_stock_tag['setting_stock_tag_group_id'] ? 'selected' : ''}} value="{{$key_setting_stock_group}}">
                                                                        {{Str::upper($setting_group)}}
                                                                    </option>
                                                                    @break
                                                                @endif 
                                                            @endforeach
                                                        @endforeach --}}
                                                    
                                                        {{-- @foreach (Setting::SettingStockGroup() as $key => $setting_group)
                                                                
                                                            <option @if($key == $setting_stock_tag['setting_stock_tag_group_id']) selected @endif value="{{$key}}">
                                                                {{Str::upper($setting_group)}}
                                                            </option>
                                                                
                                                        @endforeach --}}
                                                    
                                                    </select>
                                                @elseif ($key == 'name')
                                                    <input class="uk-input" type="text" name="setting_stock_tag[{{$keysetting_stock_tag}}][{{$key}}]" value="{{$value}}">
                                                @endif
                                            </td>
                                        @endforeach
                                    </tr>
                                   
                                {{-- @endif --}}
                            @endforeach
                        </tbody>
                    </table>
                @endif
                
            </div>
        </form>
    </li>
    
       
    <li>
        <form action="{{ route('setting.store') }}" method="POST">
            @csrf
            <div uk-grid>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Tag</label>
                    <input name="form[setting_stock_tag][tag]" class="uk-input" type="text" placeholder="Tag" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_tag']['tag'] : ''}}">
                </div>
            
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Name</label>
                    <input name="form[setting_stock_tag][name]" class="uk-input" type="text" placeholder="Name" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_tag']['name'] : ''}}">
                </div>
                
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Setting Stock Group</label>
                    <select class="uk-select" id="form-stacked-select" name="form[setting_stock_tag][setting_stock_tag_group_id]">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach($data['settingModel']->setting_stock_tag_group as $key_setting_stock_tag_group => $item_setting_stock_tag_group)
                            <option value="{{$key_setting_stock_tag_group}}">
                                {{$item_setting_stock_tag_group['name']}}
                            </option>
                        @endforeach
                        {{-- @foreach ($data['settingModel']->setting_stock_group  as $key_setting_stock_group  => $item_setting_stock_group)
                            @foreach (Setting::SettingStockGroup() as $key => $setting_group)
                                @if($key == $item_setting_stock_group['type'])                             
                                    <option selected value="{{$key_setting_stock_group}}">
                                        {{Str::upper($setting_group)}}
                                    </option>
                                    @break
                                @endif 
                            @endforeach
                        @endforeach --}}
                    </select>
                    <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
                </div>
            </div>
            
            <div class="uk-child-width-expand@m" uk-grid>
                <div>
                    <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" type="submit">
                        SAVE
                    </button>
                </div>     
            </div>
        </form>
    </li>
</ul>