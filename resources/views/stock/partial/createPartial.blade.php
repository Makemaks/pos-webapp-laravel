@php
  

@endphp

<div class="">
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#">Info</a></li>
        <li><a href="#">Option</a></li>
        <li><a href="#">Stock</a></li>
        <li><a href="#">Flag</a></li>
        <li><a href="#">Web</a></li>
        <li><a href="#">Allergens</a></li>
        <li><a href="#">Nutrition</a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li>@include('stock.partial.infoPartial')</li>
        <li>@include('stock.partial.optionPartial')</li>
        <li>@include('stock.partial.stockPartial')</li>
        <li>@include('stock.partial.flagPartial')</li>
        <li>@include('stock.partial.webPartial')</li>
        <li>@include('stock.partial.allergensPartial')</li>
        <li>@include('stock.partial.nutritionPartial')</li>
    </ul>
    
</div>