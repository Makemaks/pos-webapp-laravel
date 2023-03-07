


@php
    use App\Helpers\StringHelper;
@endphp

@foreach ($data['settingModel']->setting_key  as $keySettingKey => $itemSettingKey)
    @foreach ($itemSettingKey as $key => $stock)
                            
        @if($key == 'integer' || $key == 'decimal')

            @foreach ($stock as $stockkey => $stockitem)
                @if ($stockkey == 'type')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                        <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$key}}][{{$stockkey}}]">
                            <option value="" selected disabled>SELECT ...</option>
                            @if ($data['settingModel']->setting_stock_set_menu)
                                @foreach ($data['settingModel']->setting_stock_set_menu  as $key_setting_stock_set_menu  => $item_setting_stock_set_menu)
                                        
                                    <option value="{{$key_setting_stock_set_menu}}" @if($key_setting_stock_set_menu == $stock) selected @endif>
                                        {{$item_setting_stock_set_menu['name']}}
                                    </option>
                                        
                                @endforeach
                            @endif
                            
                        </select>
                    </div>
                @elseif ($stockkey == 'setting_key_type')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                        <select class="uk-select" id="form-stacked-select" name="form[setting_key][{{$key}}][{{$stockkey}}]">
                            <option value="" selected disabled>SELECT ...</option>
                            @if ($data['settingModel']->setting_key)
                                @foreach ($data['settingModel']->setting_key  as $key_setting_key_type  => $item_setting_key_type)
                                        
                                    <option value="{{$key_setting_key_type}}" @if($key_setting_key_type == $stock) selected @endif>
                                        {{$item_setting_key_type}}
                                    </option>
                                        
                                @endforeach
                            @endif
                            
                        </select>
                    </div>
                @elseif ($stockkey == 'value')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                        <textarea name="" id="" cols="30" rows="10"  name="form[setting_key][{{$key}}][{{$stockkey}}]"></textarea>
                    </div>

                @elseif ($stockkey == 'description')
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                        <textarea name="" id="" cols="30" rows="10"  name="form[setting_key][{{$key}}][{{$stockkey}}]"></textarea>
                    </div>
                @else
                    <div class ="uk-margin">
                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                        <input name="form[setting_key][{{$key}}][{{$stockkey}}]" class="uk-input" type="number" value="">
                    </div>
                @endif 

            @endforeach
            
        @endif

    @endforeach

@break

@endforeach


@if (Session::get('setting_setting_key') == 'cash')

    @php
        $setting_key_type = collect($data['settingModel']->setting_key)->where('setting_key_type', 1);
    @endphp

    <div class="uk-child-width-1-2 uk-grid-match" uk-grid>
        @foreach ($setting_key_type as $keySettingKey => $itemSettingKey)
            
            <div>
                
                <label class="uk-text-center">
                    <div class="uk-padding uk-light" style="background-color: #{{StringHelper::getColor()}}">
                        {{$itemSettingKey['value']}}
                        <p>{{$itemSettingKey['description']}}</p>
                    </div>
                    <input class="uk-checkbox uk-margin uk-align-center" type="checkbox">
                </label>
               
            </div>

        @endforeach
    </div>
       
    
@endif
