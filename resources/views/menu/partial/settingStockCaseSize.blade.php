@php
    use App\Models\Setting;
@endphp


@if ($data['settingModel']->edit == false)
    <ul class="uk-subnav">
        <li>
            <template></template>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
            Save
            </button>
        </li>
        <li>
            <div>
                <button class="uk-button uk-button-default uk-border-rounded" type="submit" form="settingUpdate" name="deleteButton" value="deleteButton">DELETE</button>
            </div>
        </li>
    </ul>
@endif

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
          
                @if ($data['settingModel']->setting_stock_case_size && $data['settingModel']->edit == false)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach ($data['settingModel']->setting_stock_case_size as $items)
                                    @foreach($items as $key => $item)
                                        <th>{{$key}}</th>
                                    @endforeach
                                    @break
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                           
                            @foreach ($data['settingModel']->setting_stock_case_size  as $keysetting_stock_case_size => $setting_stock_case_size)
                                <tr>
                                    <td>
                                        <div class="uk-margin">
                                            <div class="uk-form-controls">
                                                <input class="uk-checkbox" type="checkbox"
                                                    value="{{ $keysetting_stock_case_size}}"
                                                    name="caseSize_checkbox[]">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_stock_case_size}}</button>
                                    </td>
                                    
                                    @foreach ($setting_stock_case_size as $key => $value)        

                                            <td>
                                                @if ($key == 'size')
                                                    <input class="uk-input" type="number" name="setting_stock_case_size[{{$keysetting_stock_case_size}}][{{$key}}]" value="{{$value}}">
                                                @elseif($key == 'default')
                                                    <input class="uk-radio" type="radio" name="setting_stock_case_size[{{$keysetting_stock_case_size}}][{{$key}}]" value="{{$value}}" @if($value == 1) checked @endif>
                                                @elseif ($key == 'description')
                                                    
                                                        <textarea class="uk-textarea" name="setting_stock_case_size[{{$keysetting_stock_case_size}}][{{$key}}]"> {{$value}}</textarea>
                                                
                                                @endif
                                            </td>
                                    @endforeach

                                    <td>
                                
                                        <div class="uk-width-auto"><a class="uk-button uk-button-default uk-border-rounded" uk-icon="icon: pencil" href="{{route('setting.edit', ['setting' => $data['settingModel']->setting_id,  'index' => $keysetting_stock_case_size])}}"></a></div>
                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                
            </div>
        </form>
    </li>
    
       
    <li>
        @if ($data['settingModel']->edit == false)
            <form action="{{ route('setting.store') }}" method="POST">
        @else
            <form action="{{ route('setting.update', $data['settingModel']->setting_id) }}" method="POST">
             @method('PATCH')   
        @endif
        @csrf
            <div uk-grid>
                
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Description</label>
                    <input name="description" class="uk-input" type="text" placeholder="Description" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_case_size']['description'] : ''}}">
                </div>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Size</label>
                    <input name="size" class="uk-input" type="number" placeholder="Size" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_case_size']['size'] : ''}}">
                </div>

                <div>
                    <label class="uk-form-label" for="form-stacked-text">Default</label>
                    <div>
                        <input class="uk-radio" type="radio" name="default" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_case_size']['default'] : ''}}" checked>
                    </div>
                </div>

                <div>
                    @if($data['settingModel']['edit'])
                        <input name="index" class="uk-input" type="hidden" value="{{ request("index") }}">
                    @else 
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

        <div class="uk-margin">
            @if ($data['settingModel']->edit)
                <a uk-toggle="target: #modal-{{$data['settingModel']->setting_id}}-{{ request("index") }}" class="uk-button uk-width-1-1 uk-button-default uk-border-rounded uk-text-danger">
                    DELETE
                </a>

                @include('partial.modalPartial', [
                    'model_id' => $data['settingModel']->setting_id.'-'. request("index")])
            @endif
        </div>
    </li>
</ul>