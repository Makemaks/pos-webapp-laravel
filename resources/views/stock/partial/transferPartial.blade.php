@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use App\Models\Warehouse;
    use Carbon\Carbon;
   
    $warehouseList = new Stock();

    
@endphp
@if (count($data['warehouseList']) )
    <ul class="uk-subnav">
        <li>
            <template></template>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="stockTransaferUpdate" value="stockTransaferUpdate">
            Save
            </button>
        </li>
        <li>
            <div>
                <button class="uk-button uk-button-default uk-border-rounded" type="submit" form="stockTransaferUpdate" name="deleteButton" value="deleteButton">DELETE</button>
            </div>
        </li>
    </ul>
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="list"></a></li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <form id="stockTransaferUpdate" action="{{route('warehouse.update', $data['warehouseList']->toarray()[0]['warehouse_id'])}}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                <h3>TRANSFERS</h3>
                   @include('warehouse.partial.indexPartial')
                </div>
            </form>
        </li>

        <li>
            <form action="{{ route('warehouse.store') }}" method="POST">
                @csrf
                @method('POST')
                @include('warehouse.partial.createPartial')
                <div class="uk-child-width-expand@m" uk-grid>
                    <div>
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push" type="submit"></button>
                    </div>     
                </div>
            </form>
        </li>
    </ul>

@endif