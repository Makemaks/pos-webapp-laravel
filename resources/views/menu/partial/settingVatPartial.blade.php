@php
    use App\Models\Setting;
@endphp


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
          
                @if ($data['settingModel']->setting_vat)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach (Arr::first($data['settingModel']->setting_vat) as $key => $item)
                                    <th>{{$key}}</th>
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            
                           
                            @foreach ($data['settingModel']->setting_vat  as $keysetting_vat => $setting_vat)
                                {{-- @if ($setting_vat['type'] == Session::get('type')) --}}
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_vat_delete[]" value="{{$keysetting_vat}}">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_vat}}</button>
                                        </td>
                                        
                                        @foreach ($setting_vat as $key => $value)        
                                            <td>
                                                @if ($key == 'name')
                                                    <input class="uk-input" type="text" name="setting_vat[{{$keysetting_vat}}][{{$key}}]" value="{{$value}}">
                                                @elseif ($key == 'rate')
                                                    <input class="uk-input" type="text" name="setting_vat[{{$keysetting_vat}}][{{$key}}]" value="{{$value}}">
                                                @elseif ($key == 'default')

                                                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                                                        <label><input class="uk-radio" type="radio" name="setting_vat[{{$keysetting_vat}}][{{$key}}]" value="1" checked> 1</label>
                                                        <label><input class="uk-radio" type="radio" name="setting_vat[{{$keysetting_vat}}][{{$key}}]" value="0" {{$value == 0 ? 'checked' : ''}}> 0</label>
                                                    </div>
                                            
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
                    <label class="uk-form-label" for="form-stacked-text">Name</label>
                    <input name="form[setting_vat][name]" class="uk-input" type="text" placeholder="Name">
                </div>

                <div>
                    <label class="uk-form-label" for="form-stacked-text">Rate</label>
                    <input name="form[setting_vat][rate]" class="uk-input" type="text" placeholder="rate">
                </div>
                
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Default</label>
                    <div class="uk-margin uk-grid-small uk-child-width-auto uk-grid">
                        <label><input class="uk-radio" type="radio" name="form[setting_vat][default]" value="1" checked> 1</label>
                        <label><input class="uk-radio" type="radio" name="form[setting_vat][default]" value="0"> 0</label>
                    </div>
                </div>
                <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
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