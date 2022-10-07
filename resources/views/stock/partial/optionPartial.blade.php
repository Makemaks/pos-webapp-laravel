
@php
$data['settingModel']->setting_stock_group = collect($data['settingModel']->setting_stock_group)->where('type', '3');
$data['settingModel']->edit = false;
Session::flash('type', '3');
Session::flash('view', 'plu');
$data['settingModel']->setting_offer = collect($data['settingModel']->setting_offer)->where('boolean.type', '1');

@endphp

<div  class="uk-card uk-card-default uk-padding">
<h3>GENERAL</h3>
@include('menu.partial.settingStockGroupPartial')
</div>


<div class="uk-margin">
<div class="uk-card uk-card-default uk-padding">

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">{{Str::upper('set menu')}}</label>
        <select class="uk-select" name="stock_merchandise[set_menu]">
            <option selected="selected" disabled>SELECT ...</option>
            @if ($data['settingModel']->setting_stock_set_menu)
                @foreach ($data['settingModel']->setting_stock_set_menu as $key => $stock_set_menu)
                    <option value="{{$key}}" @if($key == isset($data['stockModel']->stock_merchandise['set_menu'])) selected @endif>{{$stock_set_menu['name']}}</option>
                    
                @endforeach
            @endif
        </select>
    </div>
    
    
    <div>
        <div class="uk-margin">
            <label class="uk-form-label" for="form-stacked-text">MIX & MATCH</label>
            <select class="uk-select" name="form[stock_nutrition]" id="">
                <option selected disabled>SELECT...</option>
                @if ($data['settingModel']->setting_offer)
                    @foreach ($data['settingModel']->setting_offer as $key => $setting_offer)
                        <option value="{{$key}}" @if($key == isset($data['stockModel']->stock_merchandise['set_menu'])) selected @endif>{{$setting_offer['string']['name']}}</option>
                        
                    @endforeach
                @endif
            </select>
        </div>
    </div>
    
</div>
</div>

