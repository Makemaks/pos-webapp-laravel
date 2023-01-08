@php
  

    $route = Str::before(Request::route()->getName(), '.');  

    if (isset($cartValue) == 0) {
        $cartValue=0;
        $price =0;
    }
   
    if ($quantity == NULL) {
        $quantity = 1;
    }
    
@endphp


<div class="uk-grid-small uk-child-width-auto" uk-grid>
    <div><button type="button" id="minus-stock-ID-{{$cartValue}}" onclick="Quantity(0, {{$cartValue}})" uk-icon="minus"></button></div>                           
    <div><label id="quantity-stock-ID-{{$cartValue}}" class="uk-form-width-small uk-form-small uk-text-center"> {{$quantity}} </label></div>
    <div><button type="button" id="plus-stock-ID-{{$cartValue}}" onclick="Quantity(1, {{$cartValue}} )" uk-icon="plus"></button></div>   
</div>