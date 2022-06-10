@extends('layout.master')

@push('scripts')
    <script src="{{ asset('js/cart.js') }}"></script> 
@endpush
@php
 

    use App\Helpers\CurrencyHelper;
    use App\Helpers\MathHelper;
    use App\Models\User;
    use App\Models\Order;
   $currency = CurrencyHelper::Currency();

   $totalPrice = Order::Total($data['sessionCartList']);

@endphp
@section('content')  

<div class="uk-container uk-container-xsmall">
  
        @csrf
        @if ($data['sessionCartList'] && count($data['sessionCartList']) > 0)

            <div>    
                <div class="uk-grid uk-margin-bottom" uk-grid>
                    <div class="uk-width-expand"><h2><b>Order</b> Checkout</h2></a></div>
                    <div class="uk-width-auto">
                        <h3>{{$currency}} {{$totalPrice}}</h3>
                    </div>
                </div>    
                <div class="uk-margin">
                   
                    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                        @if (User::UserType()[Auth::user()->user_type] == 'Customer')
                            <li><a href="#">Card</a></li>
                            <li><a href="#">Paypal</a></li>
                            <li><a href="#">Wallet</a></li>
                        @else
                            <li><a href="#">Store</a></li>
                        @endif
                    </ul>
                    <ul class="uk-switcher uk-margin">
                        @if (User::UserType()[Auth::user()->user_type] == 'Customer')
                            <li>@include('receipt.partial.cardPartial')</li>
                            <li>@include('receipt.partial.paypalPartial')</li>
                            <li>@include('receipt.partial.walletPartial')</li>
                        @else
                            <li>@include('receipt.partial.storePaymentPartial')</li>
                        @endif
                    </ul>

                </div> 
                
            </div>     
        @endif
            
        @include('receipt.partial.merchantPartial')
</div>
@endsection
