@php
$title = $data['title'];
$table = $data['table'];

$dataModel = $data['accountCompanyModel']->groupBy('user_id');

foreach ($dataModel as $key => $value) {
    $array[] = [
        'Number' => $value[0]->user_id,
        'First Name' => json_decode($value[0]->person_name)->person_firstname,
        'Last Name' => json_decode($value[0]->person_name)->person_lastname,
        'Customer Group' => $value[0]->company_name,
        'Email Address' => $value[0]->email,
        'Expiry Date' => '',
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
                    @foreach ($array[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($array as $keyarray => $itemarray)
                    <tr>
                        @foreach ($itemarray as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="uk-margin-top">
        <h1>{{ $title }}</h1>
    </div>
    <div class="uk-alert-danger uk-border-rounded" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>No data to display.</p>
    </div>
@endif
