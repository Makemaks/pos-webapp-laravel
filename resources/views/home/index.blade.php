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
    @include('home.partial.menuPartial')
</div>


<div>
    
    <div class="uk-grid-medium" uk-grid>

        <div class="uk-width-expand@m">
            
            

            <div class="uk-margin">
                @include('menu.home.stock-groupPartial')
            </div>

            <div class="uk-margin">
                @isset($data['stockList'])
                    @include('stock.partial.indexPartial')
                @endisset
            </div>
           
        </div>

        <div class="" id="receipt-id">
            @include('receipt.partial.indexPartial')
       </div>
    
       
    </div>
    
</div>

@endsection