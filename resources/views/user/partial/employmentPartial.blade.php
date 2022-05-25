@php
use App\Models\Stock;
use App\Helpers\ConfigHelper;

$employmentArray = [];
$employmentArray += ConfigHelper::EmploymentFunction();
$employmentArray += ConfigHelper::EmploymentMode();
$employmentArray += ConfigHelper::EmploymentEmployeeJob();
$employmentArray += ConfigHelper::EmploymentUserControl();

$userModel = json_decode($data['userModel']->employment_setup, true) ?? null;
@endphp


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
                                <label class="uk-form-label" for="form-stacked-text">{{ Str::upper($setup) }}</label>
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
