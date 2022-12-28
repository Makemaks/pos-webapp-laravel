@php
    use App\Models\Address;
    use App\Models\Stock;
    use Carbon\Carbon;
   
    $addressList = new Stock();
 
@endphp
@if (count($data['addressList']) )
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
            <form id="stockTransaferUpdate" action="{{route('address.update', $data['addressList']->toarray()[0]['address_id'])}}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                <h3>ADDRESS</h3>
                   @include('address.partial.indexPartial')
                </div>
            </form>
        </li>

        <li>
            <form action="{{ route('address.store') }}" method="POST">
                @csrf
                @method('POST')
                @include('address.partial.createPartial')
                <div class="uk-child-width-expand@m" uk-grid>
                    <div>
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push" type="submit"></button>
                    </div>     
                </div>
            </form>
        </li>
    </ul>

@endif