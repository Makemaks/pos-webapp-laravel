@php


$arrayLastZRead[] = [
    'Site' => '',
    'Last Z Read' => '',
];

@endphp
<div>
    <h3 class="uk-card-title">LAST Z READ</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arrayLastZRead[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arrayLastZRead as $keyarrayLastZRead => $itemarrayLastZRead)
                    <tr>
                        @foreach ($itemarrayLastZRead as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    
</div>
