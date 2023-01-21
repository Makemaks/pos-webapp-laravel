@php
    use App\Helpers\StringHelper;
    use App\Models\Setting;
    use App\Helpers\KeyHelper;

    $route = Str::before(Request::route()->getName(), '.');
    $settingModel = new Setting();

    if ( count($data['settingModel']->setting_key) > 1 ) {
        $data['settingModel']->setting_key = $settingModel->setting_key;
    }
@endphp

<div class="uk-margin-small">
    @if ($route != 'home' && Str::contains($route,'api') == false)
        <button type="submit" class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger">
            SAVE
        </button>
    @else
        <button type="button" class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" onclick="StoreSettingKey('setting_key')">
            SAVE
        </button>
    @endif
</div>

<form action="{{ route('setting.store') }}" method="POST" class="uk-form-horizontal" id="settingKeyFormID">
    @csrf

    <div>
        
        @foreach ($data['settingModel']->setting_key as $key => $setting_key)
                @include('setting.settingKey.partial.tablePartial')
            @break
        @endforeach

    </div>
</form>



