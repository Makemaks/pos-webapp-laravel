@php

$table = 'employeePartial';
$orderList = $data['orderList'];
$orderList = $orderList->groupBy('user_id');

if (count($orderList) > 0) {
    foreach ($orderList as $userId => $receiptList) {
        $user = App\Models\Attendance::where('attendance_user_id', $userId)
            ->where('attendance_status', '<', 2)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($user->attendance_status == 0) {
            $attendance_status = 'CLOCKED IN';
        }
        if ($user->attendance_status == 1) {
            $attendance_status = 'CLOCKED OUT';
        }

        $arraytimeAndAttendance[$userId] = [
            'Clerk' => json_decode($receiptList->first()->person_name)->person_firstname,
            'Date' => $user->created_at->format('d/m/Y'),
            'Time' => $user->created_at->format('H:i:s'),
            'Status' => $attendance_status,
        ];
    }
} else {
    $arraytimeAndAttendance[] = [
        'Clerk' => '',
        'Date' => '',
        'Time' => '',
        'Status' => '',
    ];
}

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
        <h3 class="uk-card-title">EMPLOYEE TIME AND ATTENDANCE</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach (array_values($arraytimeAndAttendance)[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arraytimeAndAttendance as $keyarraytimeAndAttendance => $itemarraytimeAndAttendance)
                    <tr
                        @if ($itemarraytimeAndAttendance['Status'] === 'CLOCKED IN') style="background-color: darkcyan; color:aliceblue"  @else class="uk-background-muted" @endif>
                        @foreach ($itemarraytimeAndAttendance as $key => $item)
                            <td> {{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
        @include('document.button')

    </div>
</div>
