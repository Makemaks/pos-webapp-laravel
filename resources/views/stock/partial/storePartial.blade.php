@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use Carbon\Carbon;
   
    $storeList = new Stock();

    
@endphp
@if (count($data['storeList']) )
    <ul class="uk-subnav">
        <li>
            <template></template>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="stockUpdate" value="stockUpdate">
            Save
            </button>
        </li>
        <li>
            <div>
                <button class="uk-button uk-button-default uk-border-rounded" type="submit" form="stockUpdate" name="deleteButton" value="deleteButton">DELETE</button>
            </div>
        </li>
    </ul>
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="list"></a></li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <form id="stockUpdate" action="{{route('store.update', $data['storeList']->toarray()[0]['store_id'])}}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div>
                <h3>STORE</h3>
                   @include('store.partial.indexPartial')
                </div>
            </form>
        </li>

        <li>
            <form action="{{ route('store.store') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('POST')
                @include('store.partial.createPartial')
                <div class="uk-child-width-expand@m" uk-grid>
                    <div>
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push" type="submit"></button>
                    </div>     
                </div>
            </form>
        </li>
    </ul>

@endif