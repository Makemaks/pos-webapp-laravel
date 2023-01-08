@extends('layout.master')
@inject('currencyHelper', 'App\Helpers\CurrencyHelper')
@php
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Setting;
    use App\Models\Company;
    use App\Helpers\StringHelper;

@endphp

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
    <script src="{{ asset('js/home.js') }}"></script> 
    <script src="{{ asset('js/setting.js') }}"></script> 
@endpush

@section('content')


<div>
    
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="home" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="user" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="tag" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="cog" class="uk-border-rounded"></a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li class="uk-overflow-auto uk-height-large uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 10">
            <div id="stockID">
                @include('home.partial.stockPartial')
            </div>
        </li>
        <li class="uk-overflow-auto uk-height-large uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 10">
            @include('person.partial.indexPartial')
        </li>
        <li class="uk-overflow-auto uk-height-large uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 10">
            {{-- @include('menu.partial.crudPartial') --}}
           <div id="settingKeyID">
                @include('setting.settingKey.create')
           </div>
        </li>
        
        <li class="uk-overflow-auto uk-height-large uk-padding-small" uk-height-viewport="offset-top: true; offset-bottom: 10">
            
        </li>
    </ul>

</div>





@endsection