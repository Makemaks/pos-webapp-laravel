@php
$i = 0;
$j = 0;
$currentDate = '';
$currentName = '';
$true = true;
$current_user_id = 0;

$currentTime = new DateTime('NOW');
$totalHours = $currentTime->diff(new DateTime('NOW'));
$totalHours = $totalHours->days * 86400 + $totalHours->h * 3600 + $totalHours->i * 60 + $totalHours->s;

$total = 0;
$grandTotal = 0;
$title = $data['title'];
$table = $data['table'];
$dataModel = $data['attendanceModel']->groupBy('user_id');
foreach ($dataModel as $user_id => $value) {
    foreach ($value as $key => $values) {
        $i++;
        $personName = json_decode($values->person_name)->person_firstname . ' ' . json_decode($values->person_name)->person_lastname;
        if ($values->attendance_status == 0) {
            $status = 'Clocked In';
            $date = Carbon\Carbon::parse($values->attendance_created_at);
            $payRate = json_decode($values->employment_user_pay)->pay_rate;
        } else {
            $status = 'Clocked Out';
            $date = Carbon\Carbon::parse($values->attendance_created_at);
        }
        $terminal = '';

        $arrayFirst[$i] = [
            'Name' => $personName,
            'Day of Week' => $date,
            'Date' => $date,
            'Time' => $date,
            'Terminal' => 'Unknown',
            'Type' => $status,
            'Pay_rate' => $payRate,
        ];
    }
}
@endphp
@if ($dataModel->count() > 0)

    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    @include('document.button')
    <div class="uk-margin-top">
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Day of Week</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Terminal</th>
                    <th>Type</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayFirst as $keyarrayFirst => $itemarrayFirst)
                    {{-- set clerk name variable on the loop --}}
                    @php
                        $loopName = $itemarrayFirst['Name'];
                    @endphp

                    {{-- Total Interval Each Clerk and its different Name --}}
                    @if ($currentName !== $loopName && $currentName !== '')
                        @php
                            $dtF = new DateTime('@0');
                            $dtT = new DateTime("@$totalHours");
                            $totalInterval = $dtF->diff($dtT);
                        @endphp

                        <tr style="background-color: rgb(255, 255, 255); font-weight: 700;">
                            <td>Total Time Worked</td>
                            <td></td>
                            <td></td>
                            <td>{{ $totalInterval->format('%hh %im') }}</td>
                            <td></td>
                            <td>$ {{ App\Helpers\MathHelper::FloatRoundUp($payRate * ($totalHours / 60 / 60), 2) }}
                            </td>
                        </tr>

                        @php
                            $currentTime = new DateTime('NOW');
                            $totalHours = $currentTime->diff(new DateTime('NOW'));
                            $totalHours = $totalHours->days * 86400 + $totalHours->h * 3600 + $totalHours->i * 60 + $totalHours->s;
                        @endphp
                    @endif

                    <tr>
                        {{-- if its different clerk, show name --}}
                        @if ($currentName !== $loopName)
                            <td style="font-weight: 700;">
                                {{ $itemarrayFirst['Name'] }}</td>
                        @else
                            <td></td>
                        @endif
                        <td>{{ $itemarrayFirst['Day of Week']->format('l') }}</td>
                        <td>{{ $itemarrayFirst['Date']->format('d/m/Y') }}</td>
                        <td>{{ $itemarrayFirst['Date']->format('H:i:s') }}</td>
                        <td>{{ $itemarrayFirst['Terminal'] }}</td>
                        <td>{{ $itemarrayFirst['Type'] }}</td>
                    </tr>

                    {{-- total interval each day --}}
                    @php
                        $loopDate = $itemarrayFirst['Date'];
                        if ($currentDate !== '') {
                            $differentDate = $loopDate->diff($currentDate);
                        }
                        $payRate = $itemarrayFirst['Pay_rate'];
                    @endphp

                    {{-- code --}}
                    @if ($loopDate->diffInDays($currentDate) == 0 && $currentDate !== '' && $currentName === $loopName)
                        <tr style="background-color: rgb(205, 205, 205); font-weight: 700;">
                            <td></td>
                            <td>{{ $itemarrayFirst['Day of Week']->format('l') }}</td>
                            <td>{{ $itemarrayFirst['Date']->format('d/m/Y') }}</td>
                            <td>{{ $differentDate->format('%Hh %im %ss') }}</td>
                            <td></td>
                            <td></td>
                        </tr>

                        {{-- counting summation date interval each days as 1 clerk --}}
                        @php
                            $seconds = $differentDate->days * 86400 + $differentDate->h * 3600 + $differentDate->i * 60 + $differentDate->s;
                            $totalHours = $totalHours + $seconds;
                        @endphp
                    @endif

                    {{-- if its last row --}}
                    @php
                        $dtF = new DateTime('@0');
                        $dtT = new DateTime("@$totalHours");
                        $totalInterval = $dtF->diff($dtT);
                    @endphp

                    @if ($keyarrayFirst === array_key_last($arrayFirst))
                        <tr style="background-color: rgb(255, 255, 255); font-weight: 700;;">
                            <td>Total Time Worked</td>
                            <td></td>
                            <td></td>
                            <td>{{ $totalInterval->format('%hh %im') }}</td>
                            <td></td>
                            <td>$ {{ App\Helpers\MathHelper::FloatRoundUp($payRate * ($totalHours / 60 / 60), 2) }}
                            </td>
                        </tr>
                        @php
                            $currentTime = new DateTime('NOW');
                            $totalHours = $currentTime->diff(new DateTime('NOW'));
                            $totalHours = $totalHours->days * 86400 + $totalHours->h * 3600 + $totalHours->i * 60 + $totalHours->s;
                        @endphp
                    @endif

                    {{-- set variables each date of loop --}}
                    @php
                        $currentDate = $loopDate;
                        $currentName = $loopName;
                    @endphp
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    <div class="uk-alert-danger uk-border-rounded" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>No data to display.</p>
    </div>
@endif
