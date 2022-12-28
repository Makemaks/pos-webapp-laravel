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
    <div><button type="button" id="minus-stock-ID-{{$cartValue}}" onclick="Quantity(0, {{$cartValue}})"  class="uk-text-danger uk-button uk-button-small uk-button-default uk-border-rounded" uk-icon="minus"></button></div>                           
    <div><label id="quantity-stock-ID-{{$cartValue}}" class="uk-form-width-small uk-form-small uk-text-center"> {{$quantity}} </label></div>
    <div><button type="button" id="plus-stock-ID-{{$cartValue}}" onclick="Quantity(1, {{$cartValue}} )" class="uk-text-primary uk-button uk-button-small uk-button-default uk-border-rounded" uk-icon="plus"></button></div>   
    <div><button type="button" id="delete-stock-ID-{{$cartValue}}" onclick="Delete({{$cartValue}})" class="uk-text-danger uk-button uk-button-small uk-button-default uk-border-rounded" uk-icon="trash"></button></div>
    <div><button type="button" value="{{$cartValue}}" id="discount-stock-ID-{{$cartValue}}" onclick="StoreSettingKey({{$cartValue}})" class="uk-button uk-button-small uk-button-default uk-border-rounded" uk-icon="tag"></button></div>
</div>