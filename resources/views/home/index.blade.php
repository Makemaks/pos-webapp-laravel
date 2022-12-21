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
        <li><a href="#" uk-icon="user" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="list" class="uk-border-rounded"></a></li>
        <li><a href="#" uk-icon="cog" class="uk-border-rounded"></a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li>
            <div id="contentID">
                @include('home.partial.stockPartial')
            </div>
        </li>
        <li>
            @include('person.partial.indexPartial')
        </li>
        <li>
            @include('home.partial.settingFinaliseKeyPartial')
        </li>
        <li>
            @include('home.partial.settingPartial')
        </li>
    </ul>

   

</div>





@endsection