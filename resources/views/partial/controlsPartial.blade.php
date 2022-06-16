@php
  

    $route = Str::before(Request::route()->getName(), '.');  

    if (isset($cartValue) == 0) {
        $cartValue=0;
        $price =0;
    }
    if (isset($cartValue) == 0) {
        $cartValue=0;
        $price = 0;
    }
    if ($quantity == NULL) {
        $quantity = 1;
    }
@endphp


    <div class="uk-grid-small uk-child-width-auto" uk-grid>
        <div><button type="button" id="minusID-{{$cartValue}}" onclick="Quantity(0, {{$cartValue}}, {{$price}})"  class="uk-text-danger uk-align-right" uk-icon="minus"></button></div>                           
        <div><input id="quantityID-{{$cartValue}}" type="text" class="uk-input uk-form-width-xsmall" value="{{$quantity}}" name="quantity"></div>
        <div><button type="button" id="plusID-{{$cartValue}}" onclick="Quantity(1, {{$cartValue}}, {{$price}})" class="uk-text-primary" uk-icon="plus"></button></div>         
    </div>

 @error('quantity')
    <div class="uk-text-danger">{{ $message }}</div>
@enderror
                 

