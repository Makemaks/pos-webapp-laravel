<input type="hidden" name="resource_type" value="voucher">
<input type="hidden" name="setting_id" value="{{ $data['settingModel']['setting_id'] }}">
<input type="hidden" name="boolean[type]" value="0">
@php
$setting_offer = null;
if (isset($data['settingModel']['setting_offer']) && $data['settingModel']['edit']) {
    $setting_offer = $data['settingModel']['setting_offer'];
} elseif (request()->old() && request()->old('resource_type') == 'voucher') {
    $setting_offer = request()->old();
}
@endphp
@if($errors && $errors->all())
    <ul class="uk-alert-danger" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <h4>{{ __('Errors') }}</h4>
        @foreach ($errors->all() as $error)
            <li class="uk-text-danger">{{ $error }}</li>
        @endforeach
    </ul>
@endif
<div uk-grid>
    <div class="uk-form-width-medium">
        <label>{{ __('Start date') }}</label>
        <input name="date[start_date]" class="uk-input" type="date" min="{{ date('Y-m-d') }}" value="{{ $setting_offer['date']['start_date'] ?? '' }}" required>
    </div>
    <div class="uk-form-width-medium">
        <label>{{ __('End date') }}</label>
        <input name="date[end_date]" class="uk-input" type="date" min="{{ date('Y-m-d') }}" value="{{ $setting_offer['date']['end_date'] ?? '' }}" required>
    </div>
</div>
<div uk-grid>
    <div class="uk-form-width-medium">
        <label>{{ __('Code') }}</label>
        <input name="string[code]" class="uk-input" type="text" value="{{ $setting_offer['string']['code'] ?? '' }}" required>
    </div>
    <div class="uk-form-width-medium">
        <label>{{ __('Name') }}</label>
        <input name="string[name]" class="uk-input" type="text" value="{{ $setting_offer['string']['name'] ?? '' }}" required>
    </div>
    <div uk-grid>
        <div class="uk-form-width-medium">
            <label>{{ __('Barcode') }}</label>
            <input name="string[barcode]" class="uk-input" type="text" value="{{ $setting_offer['string']['barcode'] ?? '' }}">
        </div>
    </div>
</div>
<div uk-grid>
    <div class="uk-form-width-large">
        <label>{{ __('Description') }}</label>
        <textarea name="string[description]" class="uk-textarea">{{ $setting_offer['string']['description'] ?? '' }}</textarea>
    </div>
</div>
<div uk-grid>
    <div class="uk-form-width-medium">
        <label>{{ __('Discount value') }}</label>
        <input name="decimal[discount_value]" class="uk-input" type="number" min="0" step="0.1" value="{{ $setting_offer['decimal']['discount_value'] ?? '' }}">
    </div>
    <div class="uk-form-width-medium">
        <label>{{ __('Quantity') }}</label>
        <input name="integer[quantity]" class="uk-input" type="number" min="0" step="1" value="{{ $setting_offer['integer']['quantity'] ?? '' }}">
    </div>
</div>
<div uk-grid>
    <div class="uk-form-width-medium">
        <label>{{ __('Per usage') }}</label>
        <input name="usage[per_usage]" class="uk-input" type="number" min="0" step="1" value="{{ $setting_offer['usage']['per_usage'] ?? '' }}">
    </div>
    <div class="uk-form-width-medium">
        <label>{{ __('Per person') }}</label>
        <input name="usage[per_person]" class="uk-input" type="number" min="0" step="1" value="{{ $setting_offer['usage']['per_person'] ?? '' }}">
    </div>
</div>

<div class="uk-margin-medium-top">
    <div>
        <label></label>
        <button class="uk-button uk-button-default uk-border-rounded" type="submit">
            {{ __('Save') }}
        </button>
    </div>
</div>
