@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Warehouse;
    use Carbon\Carbon;
    
@endphp


<ul class="uk-subnav uk-subnav-pill" uk-switcher="@isset($active) {{$active}} @endisset">
    <li><a href="#" uk-icon="list"></a></li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>

<ul class="uk-switcher uk-margin">
    <li>
        <h3>Warehouse</h3>
       @include('warehouse.partial.indexPartial')
    </li>

    <li>
        @include('warehouse.partial.createPartial')
    </li>
</ul>