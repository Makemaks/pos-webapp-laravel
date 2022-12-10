@php
    use App\Models\Store;
    use App\Models\Stock;
    use App\Models\User;
    use Carbon\Carbon;
   
    $accountList = new Stock();

    
@endphp
@if (count($data['accountList']) )
    <ul class="uk-subnav">
        <li>
            <template></template>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="accountUpdate" value="accountUpdate">
            Save
            </button>
        </li>
        <li>
            <div>
                <button class="uk-button uk-button-default uk-border-rounded" type="submit" form="accountUpdate" name="deleteButton" value="deleteButton">DELETE</button>
            </div>
        </li>
    </ul>
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a href="#" uk-icon="list"></a></li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <form id="accountUpdate" action="{{route('account.update', $data['accountList']->toarray()[0]['account_id'])}}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div>
                <h3>ACCOUNT</h3>
                   @include('account.partial.indexPartial')
                </div>
            </form>
        </li>

        <li>
            <form action="{{ route('account.store') }}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('POST')
                @include('account.partial.createPartial')
                <div class="uk-child-width-expand@m" uk-grid>
                    <div>
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-expand" uk-icon="push" type="submit"></button>
                    </div>     
                </div>
            </form>
        </li>
    </ul>

@endif