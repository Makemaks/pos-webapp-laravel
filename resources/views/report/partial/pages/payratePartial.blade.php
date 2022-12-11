@php
$i = 0;
$j = 0;
$currentDate = '';
$currentName = '';
$true = true;
$current_user_id = 0;

$currentTime = new DateTime('NOW');
$totalHours = $currentTime->diff(new DateTime('NOW'));
$totalHours = $totalHours->h * 60;

$total = 0;
$grandTotal = 0;
$title = $data['title'];
$table = $data['table'];
$dataModel = $data['employmentList']->groupBy('user_id');
// dd($dataModel);

if ($data['started'] !== '0000-00-00 00:00:00') {
    $started = Carbon\Carbon::parse($data['started']);
    $started = $started->format('d/m/Y');

    $ended = Carbon\Carbon::parse($data['ended']);
    $ended = $ended->format('d/m/Y');
} else {
    $started = false;
    $ended = false;
}

foreach ($dataModel as $user_id => $value) {
    foreach ($value as $key => $values) {
        if ($values->attendance_status == 0) {
            $timeIn = $values->created_at;
            $rate = (int) json_decode($values->employment_user_pay)->pay_rate;
            $userId = $values->user_id;
            $name = json_decode($values->person_name)->person_firstname;
        } elseif ($values->attendance_status == 1) {
            $timeOut = $values->created_at;

            $totalHours = $timeOut->diff($timeIn);
            $minutes = $totalHours->h * 60;

            $total = ($rate / 60) * $minutes;

            $array[$i] = [
                'Name' => $name,
                'Clocked In' => $timeIn,
                'Clocked Out' => $timeOut,
                'Total Hours' => $timeOut->diff($timeIn),
                'Rate' => $rate,
                'Total Wage' => \App\Helpers\MathHelper::FloatRoundUp($total, 2),
                'User ID' => $userId
            ];

            $i++; // as key
        }
    }
}
@endphp
<div class="uk-margin-top">
    <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
</div>
@if(!$data['is_pdf_csv'])
    @include('document.button')
@endif
<div class="uk-margin-top">
    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
        <thead>
            <tr>
                @foreach ($array[0] as $key => $item)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($array as $keyarray => $itemarray)
                <tr>
                    @if ($currentName !== $itemarray['Name'])
                        <td style="font-weight: 700;">
                            {{ $itemarray['Name'] }}
                        </td>
                    @else
                        <td></td>
                    @endif
                    <td>{{ $itemarray['Clocked In']->format('H:i') }}</td>
                    <td>{{ $itemarray['Clocked Out']->format('H:i') }}</td>
                    <td>{{ $itemarray['Total Hours']->format('%hh %im') }}</td>
                    <td>{{ $itemarray['Rate'] }}</td>
                    <td>{{ $itemarray['Total Wage'] }}</td>
                </tr>

                @php
                    $currentName = $itemarray['Name'];
                    $grandTotal += $itemarray['Total Wage'];
                @endphp

                @if ($loop->last)
                    <tr style="background-color:antiquewhite">
                        <td style="font-weight: 700;">Grand Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $grandTotal }}</td>
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>
</div>
