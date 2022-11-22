@php
    use App\Models\Setting;

    $collection = collect(Arr::first($data['settingModel']->setting_api));
    // dd($collection->except('ip_address'));
    $collection = $collection->keys();
    // dd($collection);
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
          
                @if ($data['settingModel']->setting_api)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach (Arr::first($data['settingModel']->setting_api) as $key => $item)
                                    @if($key == "key" || $key == "name" || $key == "type")
                                        <th>{{$key}}</th>
                                    @endif
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @foreach ($data['settingModel']->setting_api  as $keysetting_api => $setting_api)
                                <tr>
                                    <td>
                                        <input type="checkbox" name="setting_api_delete[]" value="{{$keysetting_api}}">
                                    </td>
                                    <td>
                                        <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_api}}</button>
                                    </td>
                                    
                                    @foreach ($setting_api as $key => $value)  
                                        @if($key == "key")
                                            <td><input class="uk-input" type="text" name="setting_api[{{$keysetting_api}}][{{$key}}]" value="{{$value}}" readonly></td>
                                        @elseif($key == "type")
                                            <td>
                                                <select class="uk-select" name="setting_api[{{$keysetting_api}}][{{$key}}]">
                                                    @foreach(Setting::SettingAPI() as $index => $type)
                                                        <option value="{{$index}}" {{$index == $value ? 'selected' : ''}}>{{$type}}</option>
                                                    @endforeach
                                                </select>
                                            </td>
                                        @elseif($key == "name") 
                                            <td><input class="uk-input" type="text" name="setting_api[{{$keysetting_api}}][{{$key}}]" value="{{$value}}"></td>
                                        @endif
                                    @endforeach
                                </tr>
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
                @foreach (collect(Arr::first($data['settingModel']->setting_api))->except('key') as $key => $item)
                    @if($key == 'type')
                        <div>
                            <label class="uk-form-label" for="form-stacked-text">{{$key}}</label>
                            <select class="uk-select" name="form[setting_api][{{$key}}]">
                                @foreach(Setting::SettingAPI() as $index => $type)
                                    <option value="{{$index}}">{{$type}}</option>
                                @endforeach
                            </select>
                        </div>
                    @elseif($key == 'name' || $key == 'secret') 
                        <div>
                            <label class="uk-form-label" for="form-stacked-text">{{$key}}</label>
                            <input name="form[setting_api][{{$key}}]" class="uk-input" type="text" placeholder="{{$key}}">
                        </div>
                    @endif
                @endforeach

                <div>
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