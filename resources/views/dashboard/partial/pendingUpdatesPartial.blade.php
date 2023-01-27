@php

$table = 'pendingUpdatesPartial';
$arraypendingUpdates[] = [
    'Site' => '',
    'Pending' => '',
    'Last Updated' => '',
];

@endphp

<h3 class="uk-card-title">PENDING UPDATES</h3>
<div class=" uk-overflow-auto uk-height-large">
    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
        <thead>
            <tr>
                @foreach ($arraypendingUpdates[0] as $key => $item)
                    <th>{{ $key }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($arraypendingUpdates as $keyarraypendingUpdates => $itemarraypendingUpdates)
                <tr>
                    @foreach ($itemarraypendingUpdates as $key => $item)
                        <td>{{ $item }}</td>
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
