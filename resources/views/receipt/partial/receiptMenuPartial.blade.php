@php
   use App\Models\Person;

    if (isset($data['personModel']) == false && Session::has('user-session-'.Auth::user()->user_id.'.'.'customerCartList')) {
        $customerCartList = Session::get('user-session-'.Auth::user()->user_id.'.'.'customerCartList');
        $data['personModel'] = Person::find($customerCartList[0]['value']);
    }
@endphp


<div uk-grid>
    <div class="uk-width-expand">
        
        <div id="useCustomerID">
            
            <h3 class="uk-margin-remove-bottom">
                @include('person.partial.personPartial', ['data' => $data, 'view' => 'receipt'])
            </h3>

            
        </div>

        <div id="showCustomerID">
            @if ( isset($data['personModel']) == false && Session::has('user-session-'.Auth::user()->user_id.'.'.'customerCartList') == false )
                <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="showCustomer()" uk-icon="user">
                    <span uk-icon="plus"></span>
                </button>
            @endif
        </div>
    </div>

    

    <div class="uk-align-right">
        <div class="uk-button-group">
            <a class="uk-button uk-button-default uk-border-rounded" href="{{route('receipt.index', ['view' => 'empty'])}}">
                <span uk-icon="icon: trash"></span>
            </a>
            <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="control(0)" uk-icon="pencil" id="controlShowID"></button>
            <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="control(1)" uk-icon="close" id="controlHideID" hidden></button>
        </div>
    </div>
  
</div>



