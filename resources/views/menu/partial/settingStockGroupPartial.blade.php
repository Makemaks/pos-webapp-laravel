@php
    use App\Models\Setting;
    $route = Str::before(Request::route()->getName(), '.');

@endphp


<ul class="uk-subnav uk-subnav-pill" uk-switcher="{{$active}}">
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
                   
                @endif
                
            </div>
        </form>
    </li>
    
       
    <li>
        

            @if ($route == 'menu')
                <form action="{{ route('setting.store') }}" method="POST">
        
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
            @else
               @include('setting.partial.settingStockGroupPartial')
            @endif
            
    </li>
</ul>