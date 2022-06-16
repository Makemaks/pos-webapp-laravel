@extends('layout.master')
@inject('currencyHelper', 'App\Helpers\CurrencyHelper')
@php
    use App\Models\Stock;
    use App\Models\Setting;
    use App\Helpers\StringHelper;

    $topSection = [
        "category",
        "group",
        "list-plu",
        "mix-&-match",
        "tag",
    ]
@endphp

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
@endpush

@section('content')



<div>
    
    <div class="uk-grid-medium" uk-grid>

        <div class="uk-width-expand@m">
            
            <div class="uk-margin">
                @include('home.partial.stock-groupPartial')
            </div>

           
            {{-- uk-switcher="active: 1" --}}
           <div class="uk-margin">
                @isset($data['stockList'])
                    @include('stock.partial.indexPartial')
                @endisset
           </div>
           
        </div>

        <div class="uk-width-auto@m">
            <nav class="uk-navbar-container" uk-navbar>
                <div class="uk-navbar-left">
            
                    <ul class="uk-navbar-nav">
                        <li class="uk-active"><a href="#">Active</a></li>
                        <li>
                            <a href="#">Parent</a>
                            <div class="uk-navbar-dropdown">
                                <ul class="uk-nav uk-navbar-dropdown-nav">
                                    <li class="uk-active"><a href="#">Active</a></li>
                                    <li><a href="#">Item</a></li>
                                    <li><a href="#">Item</a></li>
                                </ul>
                            </div>
                        </li>
                        <li><a href="#">Item</a></li>
                    </ul>
            
                </div>
            </nav>
            <div id="receipt-id">
                @include('receipt.partial.indexPartial')
            </div>
           
       </div>
    
       
    </div>
    
</div>

@endsection