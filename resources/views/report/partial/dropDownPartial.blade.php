@push('scripts')
    <script src="{{ asset('js/jsuites.js') }}"></script>
@endpush

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
    
    foreach ($employeeList as $key => $employee) {
        $employee_name = json_decode($employee[0]['person_name'])->person_firstname;
    
        $employeeArray[$key] = [
            'employee_name' => $employee_name,
        ];
    }
    
@endphp

   
    
    {{-- <form action="{{ route($route . '.index') }}" method="GET"> --}}
        {{-- @csrf --}}
        @include('report.partial.selectDropDownPartial')
    {{-- </form> --}}
