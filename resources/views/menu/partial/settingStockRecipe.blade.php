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
          
                @if ($data['settingModel']->setting_stock_recipe && $data['settingModel']->edit == false)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach ($data['settingModel']->setting_stock_recipe as $items)
                                    @foreach($items as $key => $item)
                                        <th>{{$key}}</th>
                                    @endforeach
                                    @break
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                           
                            @foreach ($data['settingModel']->setting_stock_recipe  as $keysetting_stock_recipe => $setting_stock_recipe)
                                <tr>
                                    <td>
                                        <div class="uk-margin">
                                            <div class="uk-form-controls">
                                                <input class="uk-checkbox" type="checkbox"
                                                    value="{{ $keysetting_stock_recipe}}"
                                                    name="stockRecipe_checkbox[]">
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_stock_recipe}}</button>
                                    </td>
                                    
                                    @foreach ($setting_stock_recipe as $key => $value)        

                                            <td>
                                                @if ($key == 'name' || $key == 'link')
                                                    <input class="uk-input" type="text" name="setting_stock_recipe[{{$keysetting_stock_recipe}}][{{$key}}]" value="{{$value}}">
                                                @elseif($key == 'default')
                                                    <input class="uk-radio" type="radio" name="setting_stock_recipe[{{$keysetting_stock_recipe}}][{{$key}}]" value="{{$value}}" @if($value == 1) checked @endif>
                                                @endif
                                            </td>
                                    @endforeach

                                    <td>
                                
                                        <div class="uk-width-auto"><a class="uk-button uk-button-default uk-border-rounded" uk-icon="icon: pencil" href="{{route('setting.edit', ['setting' => $data['settingModel']->setting_id,  'index' => $keysetting_stock_recipe])}}"></a></div>
                                        
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
                    <label class="uk-form-label" for="form-stacked-text">Name</label>
                    <input name="name" class="uk-input" type="text" placeholder="Name" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_recipe']['name'] : ''}}">
                </div>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Link</label>
                    <input name="link" class="uk-input" type="text" placeholder="Link" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_recipe']['link'] : ''}}">
                </div>

                <div>
                    <label class="uk-form-label" for="form-stacked-text">Default</label>
                    <div>
                        <input class="uk-radio" type="radio" name="default" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_recipe']['default'] : 1}}" checked>
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