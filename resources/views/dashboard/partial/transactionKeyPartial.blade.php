@php


$arraytransactionKey[] = [
    'Description' => '',
    'Quantity' => '',
    'Total' => '',
];

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">TRANSACTION KEY</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    @foreach ($arraytransactionKey[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($arraytransactionKey as $keyarraytransactionKey => $itemarraytransactionKey)
                    <tr>
                        @foreach ($itemarraytransactionKey as $key => $item)
                            <td>{{ $item }}</td>
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
