@extends('layout.master')
@inject('currencyHelper', 'App\Helpers\CurrencyHelper')
@php
    use App\Models\Stock;
    use App\Helpers\StringHelper;
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
                  
            @isset($data['stockList'])
                @include('stock.partial.indexPartial')
            @endisset
           
        </div>

        <div>
            @include('receipt.partial.indexPartial')
       </div>
    
       
    </div>
    
</div>

@endsection