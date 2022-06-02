@php

$table = 'pendingUpdatesPartial';
$arraypendingUpdates[] = [
    'Site' => '',
    'Pending' => '',
    'Last Updated' => '',
];

@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">PENDING UPDATES</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
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
</div>
