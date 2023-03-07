@php
   use App\Models\Person;
   use App\Models\Company;
   use App\Models\Setting;
   use App\Models\Order;

    if (isset($data['personModel']) == false && Session::has('user-session-'.Auth::user()->user_id.'.'.'customerCartList')) {
        $customerCartList = Session::get('user-session-'.Auth::user()->user_id.'.'.'customerCartList');
        $data['personModel'] = Person::find($customerCartList[0]['value']);
        $data['companyModel'] = Company::find($data['personModel']->persontable_id);
    }
@endphp

@include('partial.notificationPartial')


{{--     <div>{{ Str::upper(Session::get('setting_setting_key')) }}</div>
    <div class="uk-margin">
        <input type="text" class="uk-input" class="uk-form-width-expand" id="setting_setting_key_id"  autofocus onchange="searchInput(this, {{Session::get('setting_setting_key')}})">
    </div> 

    <div class="uk-margin">
        <a href="{{route( 'order.store', ['setting_setting_key' => Session::get('setting_setting_key')] )}}" class="uk-button uk-button-default uk-border-rounded uk-width-expand">
            CONFIRM
        </a>
    </div>

   <hr> --}}
   <div class="uk-margin">
        <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1" id="settingFinaliseKeyID" @if(Session::has('searchInputID')) value="{{Session::get('searchInputID')}}" @endif onclick="update(this)">Use</button>
   </div>

    <div class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">

        @if (Session::get('setting_setting_key') == 'voucher')
           
            @php
                

                if (Session::has('searchInputID')) {
                   
                    $data['settingModel'] = Setting::SettingFinaliseKey($data)['data']['settingModel'];
                    
                }else{
                    $data['settingModel'] = new Setting();
                }
            @endphp
            

            <div class="">
                @include('setting.partial.settingOfferPartial')
            </div>

        @elseif ( Session::get('setting_setting_key') == 'cash')

            @include('setting.partial.settingKeyPartial')
                
        @elseif ( Session::get('setting_setting_key') == 'credit')
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

        @elseif ( Session::get('setting_setting_key') == 'terminal')
           
            @if ($data['personModel'])
                <div  class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">
                    <div class="uk-child-width-1-2" uk-grid>
                        <div>
                            @include('person.partial.createPartial')
                        </div>
                        <div>
                            @include('company.partial.createPartial')
                        </div>
                   </div>
                </div>
               
            @else
                <p class="uk-text-danger">No Customer added</p>
            @endif

        @endif

   </div>


