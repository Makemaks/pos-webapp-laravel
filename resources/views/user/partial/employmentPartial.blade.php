@php
use App\Helpers\ConfigHelper;

$employmentArray = [];
$employmentArray += ConfigHelper::EmploymentFunction();
$employmentArray += ConfigHelper::EmploymentMode();
$employmentArray += ConfigHelper::EmploymentEmployeeJob();
$employmentArray += ConfigHelper::EmploymentUserControl();

$userModelData = [
    'employment_general' => [],
    'employment_commision' => [],
    'employment_level_default' => [],
    'employment_user_pay' => [],
];

$userModelData['employment_general'] += json_decode($data['userModel']->employment_general, true) ?? [];
$userModelData['employment_commision'] += json_decode($data['userModel']->employment_commision, true) ?? [];
$userModelData['employment_level_default'] += json_decode($data['userModel']->employment_level_default, true) ?? [];
$userModelData['employment_user_pay'] += json_decode($data['userModel']->employment_user_pay, true) ?? [];

$userModel = json_decode($data['userModel']->employment_setup, true) ?? null;
@endphp

@push('scripts')
    <script src="{{ asset('js/jsuites.js') }}"></script>
@endpush

@foreach ($userModelData as $tableName => $jsonKey)
    <div class="uk-margin">
        <h3>{{ ConfigHelper::EmploymentTable()[$tableName] }}</h3>
        <div>

            @foreach ($jsonKey as $jsonKeyName => $valueJson)
                <label class="uk-form-label"
                    for="form-stacked-text">{{ ConfigHelper::EmploymentKey()[$jsonKeyName] }}</label>

                @if ($jsonKeyName === 'default_menu_level' or $jsonKeyName === 'default_price_level')
                    <select class="uk-select uk-width-expand" name="{{ $jsonKeyName }}">

                        @foreach (ConfigHelper::$jsonKeyName() as $key => $value)
                            <option value="{{ $key }}" @if ($key == $valueJson) selected @endif>
                                {{ old($jsonKeyName, $value) }} </option>
                        @endforeach

                    </select>
                @elseif ($jsonKeyName === 'from_date' or $jsonKeyName === 'to_date')
                    <input id="{{ $jsonKeyName }}" name="{{ $jsonKeyName }}" class="uk-input calendar"
                        value="{{ $valueJson }}">
                @else
                    <input class="uk-input" type="text" name="{{ $jsonKeyName }}" value="{{ $valueJson }}">
                @endif
            @endforeach

            @if ($jsonKey == null)
                @foreach (ConfigHelper::EmploymentEachTable()[$tableName] as $key => $value)
                    <label class="uk-form-label" for="form-stacked-text">{{ ConfigHelper::EmploymentKey()[$value] }}
                    </label>

                    @if ($value === 'default_menu_level' or $value === 'default_price_level')
                        <select class="uk-select uk-width-expand" name="{{ $value }}">

                            @foreach (ConfigHelper::$value() as $key => $value)
                                <option value="{{ $value }}">{{ $key }}</option>
                            @endforeach

                        </select>
                    @elseif ($value === 'from_date' or $value === 'to_date')
                        <input id="{{ $value }}" name="{{ $value }}" class="uk-input calendar" value="">
                    @else
                        <input class="uk-input" type="text" name="{{ $value }}" value="">
                    @endif
                @endforeach
            @endif
        </div>
    </div>
@endforeach

<div class="uk-grid-match uk-grid-small uk-child-width-1-2@xl" uk-grid>

    @foreach ($employmentArray as $key => $array)
        <div>
            <div class="uk-card uk-card-default uk-padding">
                <h3>{{ Str::upper($key) }}</h3>

                <div uk-grid>

                    @foreach ($array as $keySetup => $setup)
                        @php
                            if (isset($userModel) == null) {
                                $checked = '';
                                $isflag = false;
                            } else {
                                if ($userModel[$key] != null) {
                                    $checked = '';
                                    $isflag = array_search($keySetup, $userModel[$key]);
                                } else {
                                    $checked = '';
                                    $isflag = false;
                                }
                            }
                        @endphp
                        <div>
                            <div class="uk-margin">
                                <label class="uk-form-label"
                                    for="form-stacked-text">{{ Str::upper($setup) }}</label>
                                <div class="uk-form-controls">
                                    <input class="uk-checkbox" type="checkbox"
                                        @if (is_numeric($isflag)) checked @endif name="{{ $key }}[]"
                                        value="{{ $keySetup }}">
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

            </div>
        </div>
    @endforeach

</div>
