@php
   use App\Models\Person;
   use App\Models\Company;

    if (isset($data['personModel']) == false && Session::has('user-session-'.Auth::user()->user_id.'.'.'customerCartList')) {
        $customerCartList = Session::get('user-session-'.Auth::user()->user_id.'.'.'customerCartList');
        $data['personModel'] = Person::find($customerCartList[0]['value']);
        $data['companyModel'] = Company::find($data['personModel']->persontable_id);
    }
@endphp

<form action="{{route('order.store')}}" method="POST">
    @csrf

{{--     <div>{{ Str::upper(Session::get('order_finalise_key')) }}</div>
    <div class="uk-margin">
        <input type="text" class="uk-input" class="uk-form-width-expand" autofocus id="order_finalise_key_id" onchange="searchInput(this, {{Session::get('order_finalise_key')}})">
    </div> 

    <div class="uk-margin">
        <a href="{{route( 'order.store', ['order_finalise_key' => Session::get('order_finalise_key')] )}}" class="uk-button uk-button-default uk-border-rounded uk-width-expand">
            CONFIRM
        </a>
    </div>

   <hr> --}}

    <div class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">

        @if (Session::get('order_finalise_key') == 'voucher')
            
            <div class="">
                @include('setting.partial.settingOfferPartial')
            </div>
        @elseif ( Session::get('order_finalise_key') == 'cash')

            @include('setting.partial.settingKeyPartial')
                
        @elseif ( Session::get('order_finalise_key') == 'credit')
            @if ($data['personModel'])
                <div class="uk-child-width-1-2" uk-grid>
                    <div>
                        @include('person.partial.createPartial')
                    </div>
                    <div>
                        @include('company.partial.createPartial')
                    </div>
                </div>
            @else
                <p class="uk-text-danger">No Customer added</p>
            @endif

        @elseif ( Session::get('order_finalise_key') == 'terminal')
           
            @if ($data['personModel'])
               <div class="uk-child-width-1-2" uk-grid>
                    <div>
                        @include('person.partial.createPartial')
                    </div>
                    <div>
                        @include('company.partial.createPartial')
                    </div>
               </div>
            @else
                <p class="uk-text-danger">No Customer added</p>
            @endif

        @endif

   </div>

   

</form>

