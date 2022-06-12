@php
$route = Str::before(Request::route()->getName(), '.');
$periodArray = [
    'Today' => '',
    'Yesterday' => '',
    'This Week' => '',
    'Last Week' => '',
    'This Month' => '',
    'Last Month' => '',
    'This Quarter' => '',
    'Last Quarter' => '',
];


$employeeList = $data['clerkBreakdownOption'];
$employeeList = $employeeList->groupBy('user_id');


foreach ($employeeList as $key => $employeeCollection) {
        
    foreach ($employeeCollection as $key => $employee) {
        $employee_name = json_decode($employee->person_name)->person_firstname;

        $employeeArray[$key] = [
            'employee_name' => $employee_name,
        ];
    }
    
            
}

@endphp

@push('scripts')
    <script src="{{ asset('js/jsuites.js') }}"></script>
@endpush

<form action="{{ route($route . '.index') }}" method="GET">
    @csrf
    <div uk-grid>

        <div>
            <label class="uk-form-label" for="form-stacked-text">EMPLOYEE</label>
            <select class="uk-select uk-width-expand" name="user_id">
                <option selected value="">All Employee</option>
                @isset($employeeArray)
                    @foreach ($employeeArray as $key => $period)
                        <option value="{{ $key }}">{{ $period['employee_name'] }}</option>
                    @endforeach
                @endisset
            </select>
        </div>


        <div>
            <label class="uk-form-label" for="form-stacked-text">PERIOD</label>
            <select class="uk-select uk-width-expand" name="date_period">
                <option selected value="">All Time</option>
                @isset($periodArray)
                    @foreach ($periodArray as $key => $period)
                        <option value="{{ $key }}">{{ $key }}</option>
                    @endforeach
                @endisset
               
            </select>
        </div>


        <div>
            <label class="uk-form-label" for="form-stacked-text">START DATE</label>
            <input id="started-at" name="started_at" class="uk-input calendar" placeholder="Start Date" value="">
        </div>

        <div>
            <label class="uk-form-label" for="form-stacked-text">END DATE</label>
            <input id="ended-at" name="ended_at" class="uk-input calendar" placeholder="End Date" value="">
        </div>

    </div>

    <div class="uk-margin">
        <div>
            <label class="uk-form-label" for="form-stacked-text"></label>
            <button class="uk-button uk-button-danger uk-border-rounded" type="submit">
                Submit
            </button>
        </div>
    </div>

</form>
