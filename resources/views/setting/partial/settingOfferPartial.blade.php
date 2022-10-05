@php
   use App\Models\Stock;
   use App\Models\Setting;
   use App\Helpers\ConfigHelper;
   use carbon\Carbon;

    $a = $data['settingModel'];
@endphp

@if ($data['settingModel']->edit == false)
    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
        Save
    </button>
@endif

<button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingDelete" name="settingDelete">
    Delete
</button>

<div>
    {{-- <h3>OFFERS</h3> --}}
    <form action="{{route('setting.store')}}" method="POST">
        <div class="uk-child-width-1-2" uk-grid>

            @csrf
            @foreach ((array)$data['settingModel']->setting_offer  as $keyStockoffer => $itemStockoffer)
                {{-- {{dd($data['settingModel']->setting_offer)}} --}}
                
                @foreach ($itemStockoffer as $key => $stock)
                    
                    @if($key == 'integer' || $key == 'points' || $key == 'usage' || $key == 'decimal')

                        @foreach ($stock as $stockkey => $stockitem)
                            @if ($stockkey == 'set_menu')
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                    <select class="uk-select" id="form-stacked-select" name="form[setting_offer][{{$key}}][{{$stockkey}}]">
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

                            @elseif ($stockkey == 'discount_type')
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                    <select class="uk-select" id="form-stacked-select" name="form[setting_offer][{{$key}}][{{$stockkey}}]">
                                        <option value="" selected disabled>SELECT ...</option>
                                        
                                            @foreach (Setting::SettingOfferType()  as $key_setting_discount_type  => $item_setting_discount_type)
                                                    
                                                <option value="{{$key_setting_discount_type}}" @if($key_setting_discount_type == $stock) selected @endif>
                                                    {{Str::upper($item_setting_discount_type)}}
                                                </option>
                                                    
                                            @endforeach
                                        
                                    </select>
                                </div>
                    
                            @else
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                    <input name="form[setting_offer][{{$key}}][{{$stockkey}}]" class="uk-input" type="number" value="">
                                </div>
                            @endif 
                        @endforeach
                        
                    @endif

                    @if($key == 'boolean')
                        @foreach ($stock as $stockkey => $stockitem)
                        
                            @if ($stockkey == 'status')
                                            
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                    <select class="uk-select" id="form-stacked-select" name="form[setting_offer][{{$key}}][{{$stockkey}}]">
                                        <option value="" selected disabled>SELECT ...</option>
                                        @foreach (Setting::SettingOfferStatus()  as $key_stock_offer  => $item_stock_offer)
                                                
                                            <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                {{$item_stock_offer}}
                                            </option>
                                                
                                        @endforeach
                                    </select>    
                                </div>
                            @elseif ($stockkey == 'type')
                                            
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                    <select class="uk-select" id="form-stacked-select" name="form[setting_offer][{{$key}}][{{$stockkey}}]">
                                        <option value="" selected disabled>SELECT ...</option>
                                        @foreach (Setting::SettingOfferType()  as $key_stock_offer  => $item_stock_offer)
                                                
                                            <option value="{{$key_stock_offer}}" @if($key_stock_offer == $stockitem) selected @endif>
                                                {{$item_stock_offer}}
                                            </option>
                                                
                                        @endforeach
                                    </select>    
                                </div>
                            @else
                                <div>
                                    <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                    <input name="form[setting_offer][{{$key}}][{{$stockkey}}]" class="uk-input" type="number" value="">
                                </div>
                            @endif
                        @endforeach
                    @endif

                    @if ($key == 'available_day')
                       
                
                        <div>
                            <label class="uk-form-label" for="form-stacked-text">{{Str::upper($key)}}</label>
                            <div uk-grid>
                                @foreach (Carbon::getDays() as $key_days => $item_days)
                                    @php
                                        $checked = "";
                                    /*  if (in_array($key, $data['stockModel']->stock_allergen) ) {
                                            $checked = 'checked';
                                        } */
                                    
                                    @endphp 
                            
                                
                                    
                                        <div>
                                            <label class="uk-form-label" for="form-stacked-text">{{Str::upper( Str::limit($item_days, 3 , '') )}}</label>
                                            <div class="uk-form-controls">
                                                <input class="uk-checkbox" type="checkbox" name="form[setting_offer][available_day][]" value="{{++$key_days}}" {{$checked}}>
                                            </div>
                                        </div>
                                    
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($key == 'date')
                        @foreach ($stock as $stockkey => $stockitem)
                            <div>
                                <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                <input name="form[setting_offer][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}" autocomplete="off">
                            </div>
                        @endforeach
                    @endif

                    @if($key == 'string')
                        @foreach ($stock as $stockkey => $stockitem)
                            @if ($stockkey == "description")
                                    <div>
                                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                        <textarea name="form[setting_offer][{{$key}}][{{$stockkey}}]" class="uk-textarea">{{$stockitem}}</textarea>
                                    </div>
                            @else
                                    <div>
                                        <label class="uk-form-label" for="form-stacked-text">{{Str::upper($stockkey)}}</label>
                                        <input name="form[setting_offer][{{$key}}][{{$stockkey}}]" class="uk-input" type="text" value="{{$stockitem}}">
                                    </div>
                            @endif
                        @endforeach
                    @endif

                @endforeach   

                @break

            @endforeach
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
</div>

