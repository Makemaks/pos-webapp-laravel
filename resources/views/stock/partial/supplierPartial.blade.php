@php
    use App\Models\Company;
    use App\Models\Stock;
    use Carbon\Carbon;
   
    $companyList = new Stock();
 
@endphp
@if (count($data['companyList']) )
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
            <form id="stockTransaferUpdate" action="{{route('company.update', $data['companyList']->toarray()[0]['company_id'])}}" method="POST">
                @csrf
                @method('PATCH')
                <div>
                <h3>TRANSFERS</h3>
                   @include('company.partial.indexPartial')
                </div>
            </form>
        </li>

        <li>
            <form action="{{ route('company.store') }}" method="POST">
                @csrf
                @method('POST')
                @include('company.partial.createPartial')
                <div class="uk-child-width-expand@m" uk-grid>
                    <div>
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push" type="submit"></button>
                    </div>     
                </div>
            </form>
        </li>
    </ul>

@endif