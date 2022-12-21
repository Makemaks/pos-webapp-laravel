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

{{--    <div class="uk-margin">
        <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1" id="settingFinaliseKeyID" @if(Session::has('searchInputID')) value="{{Session::get('searchInputID')}}" @endif onclick="update(this)">Use</button>
   </div>
 --}}
   
    <div class="uk-margin">
        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
            @foreach (Setting::SettingKeyGroup() as $settingKeyGroup)
                <li><a href="#">{{$settingKeyGroup}}</a></li>
            @endforeach
        </ul>
        
        <ul class="uk-switcher uk-margin">
            @foreach (Setting::SettingKeyGroup() as $settingKeyGroup)
                    @php
                        $settingKeyList = collect($data['settingModel']->setting_key)->where('group', $loop->iteration);
                    @endphp
                <li>
                    <ul uk-accordion>
                        @foreach ($settingKeyList as $settingKeyTypeKey => $settingKeyTypeItem)
                            
                            <li>
                                <a class="uk-accordion-title" href="#">{{$data['settingModel']->setting_key_type[$settingKeyTypeItem['setting_key_type']]}}</a>
                                <div class="uk-accordion-content">
                                 {{$settingKeyTypeItem['description']}}
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>
    </div>