@php


$arrayLastZRead[] = [
    'Site' => '',
    'Last Z Read' => '',
];

@endphp


<h3 class="uk-card-title">LAST Z READ</h3>
<div class="uk-overflow-auto uk-height-large">
    
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
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
