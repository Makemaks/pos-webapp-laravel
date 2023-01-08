<form action="{{ route('receipt.store') }}" id="setup-form" data-secret="{{ $data['setupIntent']->client_secret }}" method="POST">
    @csrf
    <input type="text" name="receipt_user_id" value="{{$receipt_user_id}}" hidden>
    
   <div class="uk-margin">
        <input class="uk-input" id="cardholder-name" type="text" placeholder="Card Holder Name">
   </div>

   <div class="uk-margin">
        <input class="uk-input" id="payment-method-id" type="text" name="payment_method_id" hidden>
   </div>

    
    <div class="uk-margin">
        <div id="card-element" class="uk-input"></div>
        <!-- Used to display form errors. -->
        <div id="card-errors" role="alert"></div>
    </div>
    <div class="stripe-errors"></div>
    @if (count($errors) > 0)
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
            {{ $error }}<br>
            @endforeach
        </div>
    @endif
  
    <div class="form-group text-center">
       <button type="button" id="card-button" class="uk-margin-medium uk-box-shadow-small uk-text-lead uk-light uk-border-rounded uk-width-expand uk-button uk-button-default" uk-icon="icon: tag">
          
                {{$currency}}
                @php
                    $priceVAT = $mathHelper->VAT($data['settingModel']->setting_vat, $totalPrice)['total'];
                @endphp
                <span class="uk-margin-right" id="checkoutButtonID">{{$currencyHelper->Format($priceVAT)}}</span>
          
       </button>
    </div>
</form>


<script>
    var stripe = Stripe('{{ env('STRIPE_KEY') }}');
    var elements = stripe.elements();
    var style = {
        base: {
            color: '#32325d',
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    };
    var cardElement = elements.create('card', {hidePostalCode: true,
        style: style});
    cardElement.mount('#card-element');
    cardElement.addEventListener('change', function(event) {
        var displayError = document.getElementById('card-errors');
        if (event.error) {
            displayError.textContent = event.error.message;
        } else {
            displayError.textContent = '';
        }
    });

    var cardholderName = document.getElementById('cardholder-name');
    var setupForm = document.getElementById('setup-form');
    var secret = setupForm.dataset.secret;

    setupForm.addEventListener('submit', function(ev) {
    ev.preventDefault();
    stripe.confirmCardSetup(
        secret,
        {
            payment_method: {
                type: 'card',
                card: cardElement,
                billing_details: {
                name: cardholderName.value,
                },
            },
        }
        ).then(function(result) {
            if(result.error) {
                cardButton.disable = false
            } else {
                paymentMethodHandler(result.setupIntent.payment_method)
            }
        });
    });
    


    function paymentMethodHandler(payment_method) {
        var payment_method_element = document.getElementById('payment-method-id');
        payment_method_element.value = payment_method;
        var setupForm = document.getElementById('setup-form');
        setupForm.submit();
    }
</script>