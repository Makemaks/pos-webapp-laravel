@php

$title = $data['title'];
$table = $data['table'];

$dataModel = $data['attendanceModel'];

foreach ($dataModel as $key => $value) {
    $date = Carbon\Carbon::parse($value->attendance_created_at);
    if ($value->attendance_status == 0) {
        $status = 'Clocked In';
    } else {
        $status = 'Clocked Out';
    }
    $arrayFirst[] = [
        'Clerk Number' => $value->user_id,
        'Name' => json_decode($value->person_name)->person_firstname,
        'Day Of Week' => $date->format('l'),
        'Date' => $date->format('d/m/Y'),
        'Time' => $date->format('H:i:s'),
        'Terminal' => '',
        'Type' => $status,
    ];
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
                    @foreach ($arrayFirst[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayFirst as $keyarrayFirst => $itemarrayFirst)
                    <tr>
                        @foreach ($itemarrayFirst as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="uk-alert-danger uk-border-rounded" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>No data to display.</p>
    </div>
@endif
