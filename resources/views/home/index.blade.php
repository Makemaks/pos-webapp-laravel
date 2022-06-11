@extends('layout.master')
@inject('currencyHelper', 'App\Helpers\CurrencyHelper')
@php
    use App\Models\stock;
@endphp

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
@endpush

@section('content')

@include('home.partial.menuPartial')



<div class="uk-grid-match uk-height-viewport" uk-grid>
    <div class="uk-width-expand">
        @isset($data['stockList'])
            @include('stock.partial.indexPartial')
        @endisset
    </div>

    <div>

        <div class="uk-width-large@m" id="receipt-id">
            @include('receipt.partial.indexPartial')
        </div>
       
    </div>
</div>



@endsection
