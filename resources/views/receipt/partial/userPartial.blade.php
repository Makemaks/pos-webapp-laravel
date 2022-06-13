

@php
    
   foreach ($data['userList'] as $key => $value) {
        $person_name = json_decode($data['userList']->first()->person_name);

        $searchArray[] = [
            'value' => $value->user_id,
            'text' => $person_name->person_firstname . ' ' . $person_name->person_lastname
        ];
    }
   
@endphp

<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
        
        <div class="uk-navbar-item">
            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-expand">
                     @include('partial.searchPartial', ['hidden_field_name' => 'receipt_user_id'])
                </div>
                
                <div>
                    <a href="{{route('user.create')}}" class="uk-border-rounded uk-button uk-button-default" uk-icon="icon: plus"></a>
                </div>
            </div>
        </div>
        
    </div>
   {{--  <div class="uk-navbar-right">
        <div  class="uk-navbar-item">
            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-expand">
                <input name="order_change_value" class="uk-input" id="changeValueID" placeholder="Cash" type="text">
                </div>
                <div><button type="button" class="uk-button uk-button-default" onclick="CalculateChange()">Calculate</button></div>
            </div>
        </div>   
    </div> --}}
</nav>


