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
@endpush

@section('content')


<div>
    
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="home" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="database" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="user" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="list" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="cog" class="uk-border-rounded"></a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li>
            @include('home.partial.stockPartial')
        </li>
        <li>
            <div id="contentID">
                
            </div>
        </li>
        <li>
            @include('person.partial.indexPartial')
        </li>
        <li></li>
        <li>
            @include('home.partial.settingPartial')
        </li>
    </ul>

   

</div>





@endsection