@php
    
    use App\Models\Setting;
    
    if (Session::has('searchInputID')) {
    
        $data['settingModel'] = Setting::SettingFinaliseKey($data)['data']['settingModel'];
        
    }else{
        $data['settingModel'] = new Setting();
    }
    
@endphp


<div class="">
    @include('setting.partial.settingOfferPartial')
</div>
