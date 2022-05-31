@php
$i = 0;
$j = 0;
$currentDate = '';
$true = true;
$current_user_id = 0;
$totalHours = 0;
$total = 0;
$grandTotal = 0;
$title = $data['title'];
$table = $data['table'];
$dataModel = $data['employmentList']->groupBy('user_id');

if ($data['started'] !== '0000-00-00 00:00:00') {
    $started = Carbon\Carbon::parse($data['started']);
    $started = $started->format('d/m/Y');

    $ended = Carbon\Carbon::parse($data['ended']);
    $ended = $ended->format('d/m/Y');
} else {
    $started = false;
    $ended = false;
}

if ($dataModel->count() > 0) {
    foreach ($dataModel as $user_id => $value) {
        foreach ($value as $key => $values) {
            if ($values->attendance_status == 0) {
                $timeIn = $values->created_at;
                $arrayFirst[$i]['time_in'] = $timeIn;
                $arrayFirst[$i]['date'] = $values->created_at;
                $arrayFirst[$i]['rate'] = (int) json_decode($values->employment_user_pay)->pay_rate;
                $arrayFirst[$i]['user_id'] = $values->user_id;
                $arrayFirst[$i]['person_name'] = json_decode($values->person_name)->person_firstname;
            } elseif ($values->attendance_status == 1) {
                $timeOut = $values->created_at;
                $arrayFirst[$i]['time_out'] = $timeOut;
                $i++; // as key
            }
        }

        foreach ($arrayFirst as $key => $value) {
            $report[$key] = [
                'user_id' => $value['user_id'],
                'person_name' => $value['person_name'],
                'Date' => $value['date']->format('l, d M, Y'),
                'Time In' => $value['time_in']->format('H:i'),
                'Time Out' => $value['time_out']->format('H:i'),
                'Total Hours' => $value['time_out']->diff($value['time_in'])->format('%Hh %im'),
                'Pay Rate' => '',
                'Hours' => (int) $value['time_out']->diff($value['time_in'])->format('%Hh %im'),
                'Rate' => $value['rate'],
                'Total Wage' => (int) $value['rate'] * $value['time_out']->diffInHours($value['time_in']),
            ];
        }
    }

    foreach ($report as $key => $value) {
        if ($value['user_id'] == $current_user_id || $true == true) {
            $user[$j]['user_id'] = $value['user_id'];
            $user[$j]['person_name'] = $value['person_name'];
            $total = $total + $value['Total Wage'];
            $user[$j]['total'] = $total;
            $totalHours = $totalHours + $value['Hours'];
            $user[$j]['totalHours'] = $totalHours;
            $user[$j]['data'][] = $value;
        } else {
            $j++;
            $total = 0;
            $totalHours = 0;
            $user[$j]['user_id'] = $value['user_id'];
            $user[$j]['person_name'] = $value['person_name'];
            $total = $total + $value['Total Wage'];
            $user[$j]['total'] = $total;
            $totalHours = $totalHours + $value['Hours'];
            $user[$j]['totalHours'] = $totalHours;
            $user[$j]['data'][] = $value;
        }

        $current_user_id = $value['user_id'];
        $true = false;
    }

    foreach ($user as $key => $value) {
        $grandTotal = $grandTotal + $value['total'];
    }
} else {
    $report = [];
    $user = [];
    $grandTotal = '-';
}
@endphp
<div class="uk-margin-top">
    <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
</div>
@include('document.button')
@foreach ($user as $key => $value)
    <div class="uk-margin-top">
        <caption style="text-align:left;">{{ $value['person_name'] }}</caption>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    @foreach ($value['data'][0] as $key => $item)
                        @if ($key != 'user_id' && $key != 'person_name')
                            <th>{{ $key }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($value['data'] as $keyreport => $itemreport)
                    <tr>
                        @foreach ($itemreport as $key => $item)
                            @if ($key != 'user_id' && $key != 'person_name')
                                <td>{{ $item }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>{{ $value['totalHours'] }}</td>
                    <td></td>
                    <td>{{ $value['total'] }}</td>
                </tr>

            </tbody>
            @if ($loop->last)
                <tbody>
                    <tr style="font-size:18px">
                        <td>Grand Total</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $grandTotal }}</td>

                    </tr>
                </tbody>
            @endif
        </table>
    </div>
@endforeach
