@php
    use App\Models\Setting;
    use carbon\carbon;
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
          
                @if ($data['settingModel']->setting_price_level_scheduler)
                    <ul uk-accordion>
                        @foreach (Carbon::getDays() as $key_days => $item_days)
                            <li class="{{$key_days == 0 ? 'uk-open' : ''}}">
                                <a class="uk-accordion-title" href="#">{{$item_days}}</a>
                                <div class="uk-accordion-content">
                                    <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>REF</th>
                                                @foreach (Arr::first($data['settingModel']->setting_price_level_scheduler) as $key => $item)
                                                    @if($key != 'day')
                                                        <th>{{$key}}</th>
                                                    @endif
                                                @endforeach
                                                <th></th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            @php ++$key_days @endphp
                                            @foreach ($data['settingModel']->setting_price_level_scheduler  as $keysetting_price_level_scheduler => $setting_price_level_scheduler)
                                                {{-- @if ($setting_price_level_scheduler['type'] == Session::get('type')) --}}
                                                    @if($setting_price_level_scheduler['day'] == $key_days)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="setting_price_level_scheduler_delete[]" value="{{$keysetting_price_level_scheduler}}">
                                                            </td>
                                                            <td>
                                                                <button class="uk-button uk-button-default uk-border-rounded">{{$keysetting_price_level_scheduler}}</button>
                                                            </td>
                                                            @foreach ($setting_price_level_scheduler as $key => $value) 
                                                                @if($key != 'day')
                                                                    <td>
                                                                        @if($key == 'price_level')
                                                                            <select name="setting_price_level_scheduler[{{$keysetting_price_level_scheduler}}][{{$key}}]" class="uk-select">
                                                                                <option value="" selected disabled>SELECT...</option>
                                                                                @foreach($data['settingModel']['stock_costs'] as $keyStockCost => $stock_cost)
                                                                                    <option value="{{$stock_cost}}" {{$value == $stock_cost ? 'selected' : ''}}>{{$stock_cost}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        @else  
                                                                            <input class="uk-input" type="text" name="setting_price_level_scheduler[{{$keysetting_price_level_scheduler}}][{{$key}}]" value="{{$value}}">
                                                                        @endif
                                                                    </td>
                                                                @else 
                                                                <input type="hidden" value="{{$key_days}}" name="setting_price_level_scheduler[{{$keysetting_price_level_scheduler}}][{{$key}}]">
                                                                @endif
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                                   
                                                {{-- @endif --}}
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
                
            </div>
        </form>
    </li>
    
       
    <li>
        <form action="{{ route('setting.store') }}" method="POST">
            @csrf
            <div uk-grid>
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Time</label>
                    <input name="form[setting_price_level_scheduler][time]" class="uk-input" type="text" placeholder="Date & Time">
                </div>
            
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Day</label>
                    <select class="uk-select" id="form-stacked-select" name="form[setting_price_level_scheduler][day]">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach (Carbon::getDays() as $key_days => $item_days)
                            <option value="{{++$key_days}}">{{$item_days}}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="uk-form-label" for="form-stacked-text">Price Level</label>
                    <select class="uk-select" id="form-stacked-select" name="form[setting_price_level_scheduler][price_level]">
                        <option value="" selected disabled>SELECT ...</option>
                        @foreach($data['settingModel']['stock_costs'] as $keyStockCost => $stock_cost)
                            <option value="{{$stock_cost}}">{{$stock_cost}}</option>
                        @endforeach
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