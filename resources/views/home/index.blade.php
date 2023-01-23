@extends('layout.master')
@inject('currencyHelper', 'App\Helpers\CurrencyHelper')
@php
    use App\Models\Stock;
    use App\Models\Store;
    use App\Models\User;
    use App\Models\Setting;
    use App\Models\Warehouse;
    use App\Models\Company;
    use App\Helpers\KeyHelper;
@endphp

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
    <script src="{{ asset('js/home.js') }}"></script> 
    <script src="{{ asset('js/setting.js') }}"></script> 
@endpush

@section('content')


<div>
    @include('home.partial.navigation')

    <div class="uk-overflow-auto uk-height-large uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 10">

        {{-- @include('stock.partial.groupPartial') --}}
   
            <ul class="uk-switcher switcher-container uk-margin">
               
                @foreach (Setting::SettingStockSet() as $setting_stock_group_key => $setting_stock_group_item)
                    <li>
                        <div class="uk-margin-small">{{Str::upper($setting_stock_group_item)}}</div>

                        @php
                            $setting_stock_set = collect($data['settingModel']->setting_stock_set)->where('type', $setting_stock_group_key);
                        @endphp
                        <div class="uk-child-width-1-4@s uk-grid-small" uk-grid>
                            @foreach ($setting_stock_set as $item)
                                <div>
                                    <div class="uk-box-shadow-small uk-padding-small" value="{{$setting_stock_group_key}}">
                                        {{$item['name']}}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </li>
                @endforeach

                
                @foreach (Setting::SettingKeyGroup() as $setting_key_key => $setting_key_item)
                    <li>
                        <div class="uk-margin-small">{{Str::upper($setting_key_item)}}</div>
                        
                        <div class="uk-child-width-1-4@s uk-grid-small" uk-grid>
                            @foreach (KeyHelper::Type()[$setting_key_key] as $key_helper_key  => $key_helper_item)
                            
                                <div>
                                    <div class="uk-box-shadow-small uk-padding-small" value="{{$key_helper_key}}">
                                        {{$key_helper_item}}
                                    </div>
                                </div>
                                
                            @endforeach
                        </div>
                    </li>
                @endforeach

               

                <li>
                    <div id="stockID">
                        @include('home.stock.index')
                    </div>
                    {{-- <div id="settingKeyID">
                        @include('setting.key.create')
                    </div> --}}
                </li>

                <li>
                    CUSTOMER
                    @include('person.partial.indexPartial')
                </li>

                <li>
                    SETTING
                </li>
            </ul>

        
      

    </div>

</div>

@endsection