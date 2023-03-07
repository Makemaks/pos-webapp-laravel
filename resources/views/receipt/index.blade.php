@extends('layout.master')


@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
@endpush
    @php
        use App\Helpers\CurrencyHelper;
        use App\Helpers\MathHelper;
        use App\Models\Order;

        $currency = CurrencyHelper::Currency();
        $totalPrice = 0;

    @endphp
@section('content') 

    @include('receipt.partial.indexPartial')
   
@endsection
