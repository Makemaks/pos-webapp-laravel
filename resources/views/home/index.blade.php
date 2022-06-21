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
    
</div>





@endsection