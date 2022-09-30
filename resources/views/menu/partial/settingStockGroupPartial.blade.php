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
          
                @if ($data['settingModel']->setting_stock_group && $data['settingModel']->edit == false)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach ($data['settingModel']->setting_stock_group as $items)
                                    @foreach($items as $key => $item)
                                        <th>{{$key}}</th>
                                    @endforeach
                                    @break
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            
                           
                            @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
                                @if ($setting_stock_group['type'] == Session::get('type'))
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_stock_group_delete[]" value="{{$keysetting_stock_group}}">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_stock_group}}</button>
                                        </td>
                                        
                                        @foreach ($setting_stock_group as $key => $value)        

                                                <td>
                                                    @if ($key == 'code')
                                                        
                                                        <input class="uk-input" type="number" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]" value="{{$value}}">
                                                    @elseif ($key == 'type')
                                                                    
                                                        <select class="uk-select" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">
                                                            <option selected="selected" disabled>SELECT ...</option>
                                                        
                                                            @foreach (Setting::SettingStockGroup() as $key => $setting_group)
                                                                    
                                                                <option @if($key == $setting_stock_group['type']) selected @endif value="{{$key}}">
                                                                    {{Str::upper($setting_group)}}
                                                                </option>
                                                                    
                                                            @endforeach
                                                        
                                                        </select>
                                                    @elseif ($key == 'name')
                                                        
                                                            <textarea class="uk-textarea" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]"> {{$value}}</textarea>
                                                    
                                                    @endif
                                                </td>
                                            
                                            
    
                                        @endforeach
    
                                        {{-- <td>
                                    
                                            <div class="uk-width-auto"><a class="uk-button uk-button-default uk-border-rounded" uk-icon="icon: pencil" href="{{route('setting.edit', ['setting' => $data['settingModel']->setting_id,  'index' => $keysetting_stock_group])}}"></a></div>
                                           
                                        </td> --}}
                                    </tr>
                                   
                                @endif
                            @endforeach
                        </tbody>
                    </table>
                @endif
                
            </div>
        </form>
    </li>
    
       
    <li>
        {{-- @if ($data['settingModel']->edit == false) --}}
            <form action="{{ route('setting.store') }}" method="POST">
        {{-- @else
            <form action="{{ route('setting.update', $data['settingModel']->setting_id) }}" method="POST">
             @method('PATCH')   
        @endif --}}
                @csrf
                <div uk-grid>
                    <div>
                        <label class="uk-form-label" for="form-stacked-text">Code</label>
                        <input name="form[setting_stock_group][code]" class="uk-input" type="number" placeholder="Code" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_group']['code'] : ''}}">
                    </div>
                
                    <div>
                        <label class="uk-form-label" for="form-stacked-text">Name</label>
                        <input name="form[setting_stock_group][name]" class="uk-input" type="text" placeholder="Name" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_group']['name'] : ''}}">
                    </div>
                    
                    <div>
                        @if($data['settingModel']['edit'])
                            <input name="index" class="uk-input" type="hidden" value="{{ request("index") }}">
                        @else 
                            <input name="form[setting_stock_group][type]" class="uk-input" type="hidden" value="{{Session::get('type')}}">
                            <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
                        @endif
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

        {{-- <div class="uk-margin">
            @if ($data['settingModel']->edit)
                <a uk-toggle="target: #modal-{{$data['settingModel']->setting_id}}-{{ request("index") }}" class="uk-button uk-width-1-1 uk-button-default uk-border-rounded uk-text-danger">
                    DELETE
                </a>

                @include('partial.modalPartial', [
                    'model_id' => $data['settingModel']->setting_id.'-'. request("index")])
            @endif
        </div> --}}
    </li>
</ul>