@php

$title = $data['title'];
$table = $data['table'];

if ($title === 'customer company') {
    $dataModel = $data['addressCompany']->groupBy('user_id');
} elseif ($title === 'customer person') {
    $dataModel = $data['addressPerson']->groupBy('user_id');
}

foreach ($dataModel as $key => $value) {
    $person_name = $value[0]->person_name;
    $address_line = $value[0]->address_line;
    $address_phone = $value[0]->address_phone;
    $arrayFirst[] = [
        'Number' => $value[0]->person_id,
        'First Name' => json_decode($person_name, true)['person_firstname'],
        'Last Name' => json_decode($person_name, true)['person_lastname'],
        'Address 1' => json_decode($address_line, true)['address_line_1'],
        'Address 2' => json_decode($address_line, true)['address_line_2'],
        'Address 3' => json_decode($address_line, true)['address_line_3'],
        'PostCode' => json_decode($address_line, true)['address_postcode'],
        'Phone 1' => json_decode($address_phone, true)['address_phone_1'],
        'Phone 2' => json_decode($address_phone, true)['address_phone_2'],
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
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    <div class="uk-alert-danger uk-border-rounded" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>No data to display.</p>
    </div>
@endif
