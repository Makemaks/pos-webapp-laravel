@php
  

    $route = Str::before(Request::route()->getName(), '.');  

    if (isset($cartValue) == 0) {
        $cartValue=0;
        $price =0;
    }
   
    if (isset($quantity) == false) {
        $quantity = 1;
    }
    
@endphp


<div class="uk-child-width-expand@s uk-text-center" uk-grid>
    <div>
        <div class="uk-card uk-card-default uk-card-body">Item</div>
    </div>
    <div>
        <div class="uk-card uk-card-default uk-card-body">Item</div>
    </div>
    <div>
        <div class="uk-card uk-card-default uk-card-body">Item</div>
    </div>
</div>