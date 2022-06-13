
@php
        use App\Helpers\CurrencyHelper;
@endphp

<div class="uk-margin uk-height-large">
    <form id="setup-form" data-secret="{{Session::get('CLIENT_SECRET')}}">
        @csrf

        {{-- data-stripe-publishable-key="{{ Session::get('STRIPE_KEY') }}" --}}
        <div class='card uk-margin'>
            <div>
                <label class=''>Name on Card</label> 
                <input id="cardholder-name" class="uk-input" type='text'>
            </div>
           {{--  <div class="w3-border-bottom w3-width-100"></div> --}}
        </div>
      
        <div class='card uk-margin uk-input' id="card-element">
            <!-- a Stripe Element will be inserted here. -->
        </div>
        <!-- Used to display Element errors -->
        <div id="card-errors" role="alert" class="uk-margin">

        </div>
          
        <div class="uk-margin-medium">
            <button type="button" onclick="postForm()" class="uk-box-shadow-small uk-width-expand uk-text-lead uk-light uk-border-rounded uk-button uk-button-danger" uk-icon="icon: tag">
                {{ CurrencyHelper::Format( SESSION::GET('GRAND_TOTAL') )}}
            </button>
        </div>
        
    </form>
</div>
