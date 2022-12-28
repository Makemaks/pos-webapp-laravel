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

@include('setting.partial.settingKeyPartial')


