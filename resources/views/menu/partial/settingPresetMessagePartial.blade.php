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
            {{Str::upper(Session::get('view'))}}
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
          
                @if ($data['settingModel']->setting_preset_message)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach (Arr::first($data['settingModel']->setting_preset_message) as $key => $item)
                                    <th>{{$key}}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                           
                            @foreach ($data['settingModel']->setting_preset_message  as $keysetting_preset_message => $setting_preset_message)
                                {{-- @if ($setting_preset_message['type'] == Session::get('type')) --}}
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_preset_message_delete[]" value="{{$keysetting_preset_message}}">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_preset_message}}</button>
                                        </td>
                                        
                                        @foreach ($setting_preset_message as $key => $value)        
                                            <td>
                                                <input class="uk-input" type="text" name="setting_preset_message[{{$keysetting_preset_message}}][{{$key}}]" value="{{$value}}">
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
                    <label class="uk-form-label" for="form-stacked-text">Message</label>
                    <input name="form[setting_preset_message][name]" class="uk-input" type="text" placeholder="Name">
                </div>
                
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