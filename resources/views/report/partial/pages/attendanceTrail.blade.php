@php

$title = $data['title'];
$table = $data['table'];

$dataModel = $data['employmentList']->groupBy('attendance_id');

foreach ($dataModel as $key => $value) {
    if ($value->first()->attendance_status == 0) {
        $status = 'Clocked In';
    } else {
        $status = 'Clocked Out';
    }
    $arrayFirst[] = [
        'Clerk Number' => $value[0]->user_id,
        'Name' => json_decode($value[0]->person_name)->person_firstname,
        'Day Of Week' => $value[0]->created_at->format('l'),
        'Date' => $value[0]->created_at->format('d/m/Y'),
        'Time' => $value[0]->created_at->format('H:i:s'),
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
    <p>No data is available for the filters you have selected</p>
@endif
