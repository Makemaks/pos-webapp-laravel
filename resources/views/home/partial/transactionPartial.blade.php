@php
     use App\Helpers\NumpadHelper;
    $setting_key_collection = collect($data['settingModel']->setting_key)->where('setting_key_type', 1);
@endphp

{{-- @foreach ($setting_key_collection as $setting_key)
<div class="uk-margin">
    <div class="uk-padding uk-card-default uk-card uk-border-rounded">
        <p class="uk-text-truncate">{{Str::limit($setting_key['description'], 10)}}</p>
    </div>
</div>
@endforeach --}}




