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


<div class="uk-grid-medium uk-child-width-auto" uk-grid id="controlID-{{$cartValue}}" hidden>
    <div><button type="button" id="minusID-{{$cartValue}}" onclick="Quantity(0, {{$cartValue}}, {{$price}})"  class="uk-text-danger uk-align-right" uk-icon="minus"></button></div>                           
    <div><label id="quantityID-{{$cartValue}}" class="uk-form-width-small uk-form-small uk-text-center"> {{$quantity}} </label></div>
    <div><button type="button" id="plusID-{{$cartValue}}" onclick="Quantity(1, {{$cartValue}}, {{$price}})" class="uk-text-primary" uk-icon="plus"></button></div>   
   <div><button type="button" id="deleteID-{{$cartValue}}" onclick="Delete({{$cartValue}})" class="uk-text-danger" uk-icon="trash"></button>   </div>   
</div>


                 

