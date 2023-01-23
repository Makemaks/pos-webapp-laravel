@php
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Setting;
    use App\Models\Company;
    use App\Helpers\KeyHelper;
@endphp

<div class="uk-inline">
    <button class="uk-button uk-button-default" type="button" uk-icon="chevron-down">{{Setting::SettingKeyGroup()[ $data['setupList']['requestInput']['setting_key_group'] ]}}</button>
    <div uk-dropdown="mode: click">
       <div class="uk-overflow-auto uk-height-large uk-padding-small">
            
            <ul class="uk-list">
                <li>
                    <div class="uk-search uk-search-default">
                        <span uk-search-icon></span>
                        <input class="uk-search-input" type="search" onclick="showKeypad()" onchange="searchInput(this)" autocomplete="off">
                    </div>
                </li>

                <hr>
                <li>
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
                </li>
            </ul>

                <hr>
            <ul class="uk-list uk-link-reset" uk-switcher="active:10; connect: .switcher-container">
                <li></li>
                @foreach (Setting::SettingStockSet() as $setting_stock_group)
                    <li class="toggle-link"{{-- onclick="stockGroup({{$loop->iteration}}, '{{$setting_stock_group}}', null)" --}}>
                        <a class="uk-dropdown-close" href="#">{{Str::upper($setting_stock_group)}}</a>
                    </li>
                @endforeach

                <hr>
                @foreach (Setting::SettingKeyGroup() as $keySettingKeyGroup =>$valueSettingKeyGroup)
                    <li class="toggle-link">
                        <a class="uk-dropdown-close" href="#">{{Str::upper($valueSettingKeyGroup)}}</a>
                    </li>
                @endforeach
                <hr>

                <li class="toggle-link">
                    <a class="uk-dropdown-close" href="#">
                        STOCK
                    </a>
                </li>
                <hr>

                <li class="toggle-link">
                    <a class="uk-dropdown-close" href="#">
                        CUSTOMER
                    </a>
                </li>
                <hr>

                <li class="toggle-link">
                    <a class="uk-dropdown-close" href="#">
                        SETTING
                    </a>
                </li>
            </ul>
       </div>
    </div>
</div>