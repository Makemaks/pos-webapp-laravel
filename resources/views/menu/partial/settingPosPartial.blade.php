@php
    use App\Models\Setting;

    $collection = collect(Arr::first($data['settingModel']->setting_pos));
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
          
                @if ($data['settingModel']->setting_pos)
                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                        <thead>
                            <tr>
                                <th></th>
                                <th>REF</th>
                                @foreach (Arr::first($data['settingModel']->setting_pos) as $key => $item)
                                    @if($key == 'cash' || $key == 'credit')
                                        @foreach($item as $key_item => $sub_item)
                                            <th>{{ $key.'_'.$key_item }}</th>
                                        @endforeach
                                    @else 
                                        <th>{{$key}}</th>
                                    @endif
                                @endforeach
                                <th></th>
                            </tr>
                        </thead>
    
                        <tbody>
                            @foreach ($data['settingModel']->setting_pos  as $keysetting_pos => $setting_pos)
                                {{-- {{dd($setting_pos)}} --}}
                                <tr>
                                    <td>
                                        <input type="checkbox" name="setting_pos_delete[]" value="{{$keysetting_pos}}">
                                    </td>
                                    <td>
                                        <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_pos}}</button>
                                    </td>
                                    
                                    @foreach ($setting_pos as $key => $value)  
                                        @if($key == "cash" || $key == "credit")
                                            @foreach($value as $key_value => $sub_value)
                                                <td><input class="uk-input" type="text" name="setting_pos[{{$keysetting_pos}}][{{$key}}][{{$key_value}}]" value="{{$sub_value}}"></td>
                                            @endforeach
                                        @elseif($key == "ip_address")
                                            <td>{{$value}}</td>
                                            <input type="hidden" name="setting_pos[{{$keysetting_pos}}][{{$key}}]" value="{{getHostByName(getHostName())}}">
                                        @else
                                            <td><input class="uk-input" type="text" name="setting_pos[{{$keysetting_pos}}][{{$key}}]" value="{{$value}}"></td>
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
                @foreach (collect(Arr::first($data['settingModel']->setting_pos))->except('ip_address') as $key => $item)
                    @if($key == 'cash' || $key == 'credit')
                        @foreach($item as $key_item => $sub_item)
                            <div>
                                <label class="uk-form-label" for="form-stacked-text">{{$key.'_'.$key_item}}</label>
                                <input name="form[setting_pos][{{$key}}][{{$key_item}}]" class="uk-input" type="text" placeholder="{{$key.'_'.$key_item}}">
                            </div>
                        @endforeach
                    @else 
                        <div>
                            <label class="uk-form-label" for="form-stacked-text">{{$key}}</label>
                            <input name="form[setting_pos][{{$key}}]" class="uk-input" type="text" placeholder="{{$key}}">
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