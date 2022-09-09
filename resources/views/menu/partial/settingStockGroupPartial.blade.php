@php
    use App\Models\Setting;
@endphp


@if ($data['settingModel']->edit == false)
    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
        Save
    </button>
@endif

<ul class="uk-subnav uk-subnav-pill" @if ( $data['settingModel']->edit == false ) uk-switcher="active:0" @else uk-switcher="active:1" @endif>
    <li><a href="#">{{Str::upper(Request::get('view'))}}</a></li>
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
                                <th>REF</th>
                            @foreach ($data['settingModel']->setting_stock_group[1] as $key => $item)
                                    <th>{{$key}}</th>
                            @endforeach
                            <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            
                           
                            @foreach ($data['settingModel']->setting_stock_group  as $keysetting_stock_group => $setting_stock_group)
                                @if ($setting_stock_group['type'] == Session::get('type'))
                                    <tr>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_stock_group}}</button>
                                        </td>
                                    
                                        @foreach ($setting_stock_group as $key => $value)          
    
                                                <td>
                                                    @if ($key == 'code')
                                                        
                                                        <input class="uk-input" type="number" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]" value="{{$value}}">
                                                    @elseif ($key == 'type')
                                                                    
                                                        <select class="uk-select" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]" disabled>
                                                            <option selected="selected" disabled>SELECT ...</option>
                                                        
                                                            @foreach (Setting::SettingStockGroup() as $key => $setting_group)
                                                                    
                                                                <option @if($key == $setting_stock_group['type']) selected @endif value="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]">
                                                                    {{Str::upper($setting_group)}}
                                                                </option>
                                                                    
                                                            @endforeach
                                                        
                                                        </select>
                                                    @elseif ($key == 'name')
                                                        
                                                            <textarea class="uk-textarea" name="setting_stock_group[{{$keysetting_stock_group}}][{{$key}}]"> {{$value}}</textarea>
                                                    
                                                    @endif
                                                </td>
                                            
                                            
    
                                        @endforeach
    
                                        <td>
                                    
                                            <div class="uk-width-auto"><a class="uk-button uk-button-default uk-border-rounded" uk-icon="icon: pencil" href="{{route('setting.edit', ['setting' => $data['settingModel']->setting_id,  'index' => $keysetting_stock_group])}}"></a></div>
                                           
                                        </td>
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
        <form action="{{ route('setting.store') }}" method="POST">
            @csrf
            <div uk-grid>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Code</label>
                    <input name="code" class="uk-input" type="number" placeholder="Code" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_group']['code'] : ''}}">
                </div>
            
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Name</label>
                    <input name="name" class="uk-input" type="text" placeholder="Name" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_group']['name'] : ''}}">
                </div>
                
                <div>
                    @if($data['settingModel']['edit'])
                        <input name="index" class="uk-input" type="hidden" value="{{ request("index") }}">
                    @else 
                        <input name="type" class="uk-input" type="hidden" value="{{Session::get('type')}}">
                        <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
                    @endif
                </div>
            </div>
            @dump($data['settingModel']['setting_stock_group'])
            <div class="uk-child-width-expand@m" uk-grid>
                <div>
                    <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" type="submit">
                        SAVE
                    </button>
                </div>

                <div>
                    @if ($data['settingModel']->edit)
                        <a uk-toggle="target: #modal-{{$data['settingModel']->setting_id}}-{{$data['settingModel']['setting_stock_group']['code']}}" class="uk-button uk-width-1-1 uk-button-default uk-border-rounded uk-text-danger">
                            DELETE
                        </a>

                        @include('partial.modalPartial', [
                            'model_id' => $data['settingModel']->setting_id.'-'.$data['settingModel']['setting_stock_group']['code']])
                    @endif
                </div>
     
            </div>

        </form>
    </li>
</ul>