@php
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Setting;
    use App\Models\Company;
    use App\Helpers\KeyHelper;

   $settingModel = new Setting();
@endphp

<div class="uk-grid-small uk-child-width-auto uk-margin" uk-grid>

    <div>
        <select name="stock_group" id="stockGroupTypeID" class="uk-select">
            <option disabled selected>FILTER... </option>
            @foreach (Setting::SettingStockGroup() as $setting_stock_group)
                <option onclick="stockGroup({{$loop->iteration}}, '{{$setting_stock_group}}', null)">{{Str::upper($setting_stock_group)}}</option>
            @endforeach
        </select>
    </div>

    <div>
        
        @foreach ($settingModel->setting_key as $key => $setting_key)
            
                @if (head($setting_key) == 'setting_key_group')
                    @include('setting.settingKey.partial.tablePartial')
                @endif
            @break
        @endforeach
    </div>
    
    <div>
        <div class="uk-inline">
            <button class="uk-button uk-button-default" type="button" uk-icon="chevron-down">PRICE</button>
            <div uk-dropdown="mode: click">
                <div class="uk-margin">
                    <select name="setting_stock_price_group" class="uk-select">
                        <option disabled selected>PRICE GROUP...</option>
                        @for ($i = 1; $i < $data['settingModel']->setting_stock_price_group + 1; $i++)
                            <option value="{{$i}}" @if ($data['setupList']['requestInput']['setting_stock_price_group'] == $i) selected @endif>GROUP {{$i}}</option>
                        @endfor
                    </select>
                </div>

                <div class="uk-margin">
                    <select name="setting_stock_price_level" class="uk-select" onchange="IndexStock()">
                        <option disabled selected>PRICE LEVEL...</option>
                        @foreach ($data['settingModel']->setting_stock_price_level as $setting_stock_price_level)
                            <option value="{{$loop->iteration}}" @if ($data['setupList']['requestInput']['setting_stock_price_level'] == $loop->iteration) selected @endif>{{Str::upper($setting_stock_price_level['name'])}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div>
        <button class="uk-button uk-button-default uk-border-rounded" type="button" uk-icon="search" onclick="showKeypad()" onchange="searchInput(this)" autocomplete="off">
    </div>
</div>