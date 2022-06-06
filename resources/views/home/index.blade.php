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



<div uk-grid>
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

{{-- <div class="uk-accordion-content">
    <div class="uk-margin-left uk-margin-right uk-align-center" uk-slider>

        <div class="uk-position-relative">
            
            <div class="uk-slider-container">
                <div class="uk-grid-match uk-grid-small uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
                    @include('category.partial.indexPartial')
                </div>
            </div>
            
            <div class="uk-hidden@s uk-light">
                <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
            </div>
            
            <div class="uk-visible@s">
                <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
                <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
            </div>
            
        </div>
            
        <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>
            
    </div>
</div> --}}
@endsection
