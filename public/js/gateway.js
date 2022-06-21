{
    var stripeElement = '';
    var cardElement = '';
}


  
function stripe(){
  // Create a Stripe client
    stripeElement = Stripe('pk_test_51IT1oKIsAyzPkVnu6KvDEOeNtomWeqwyet5eQ54q0rRYfnAVwOuwGCDPto5LGzIPzRQmL5bKzFExUivkWqBP3pVx00kyCqcZh4');

    // Create an instance of Elements
    var stripeElements = stripeElement.elements();

    // Custom styling can be passed to options when creating an Element.
    // (Note that this demo uses a wider set of styles than the guide below.)
    var style = {
      base: {
        color: '#32325d',
        lineHeight: '18px',
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

    // Create an instance of the card Element
    cardElement = stripeElements.create('card', {style: style});

    // Add an instance of the card Element into the `card-element` <div>
    cardElement.mount('#card-element');

    // Handle real-time validation errors from the card Element.
    cardElement.addEventListener('change', function(event) {
      var displayError = document.getElementById('card-errors');
      if (event.error) {
        displayError.textContent = event.error.message;
      } else {
        displayError.textContent = '';
      }
    });

  
    //sessionStorage.setItem("card",  JSON.stringify(card));
    //sessionStorage.setItem("stripe",  JSON.stringify(stripe));
    
}
  
function postForm(){
      // Handle form submission.

    //var card = JSON.parse(sessionStorage.getItem("card"));
    //var stripe = JSON.parse(sessionStorage.getItem("stripe"));

    var setupForm = document.getElementById('setup-form');
    var secret = setupForm.dataset.secret;

    var cardholderName = document.getElementById('cardholder-name');
  

    stripeElement.confirmCardPayment(
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
              //cardButton.disable = false
          } else {
              if (result.paymentIntent.status === 'succeeded') {
                paymentMethodHandler(result.paymentIntent)
              }
              
          }
      });
    
}
  

//process payment
function paymentMethodHandler(paymentIntent) {
  
  //var bag = sessionStorage.getItem("bag");
  //var model = $('form').serialize();
    
    $.ajax({
      url: "/gateway-api",
      method: 'GET',
      data: {
        model: JSON.stringify(paymentIntent),
        action:'process',
      },
      
      success:function(data){

          if (data['success']) {
             alert('processed');
          }else{
            alert('processed');
          }
      },

    });
}


//open payment
function PaymentType(payment_type, priceVAT){

  if ( priceVAT > 0) {
    $.ajax({
      url: "/gateway-api",
      method: 'GET',
      data: {
          payment_type:payment_type,
          total:priceVAT,
          action:'payment'

      },
      success:function(data){

          if (data['success']) {
              document.getElementById('paymentID').innerHTML = data['view'];
              stripe();
          }
      },

    });
  }
}