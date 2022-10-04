<a class="uk-button uk-button-primary uk-border-rounded" href="{{route('reservation.create')}}">Create</a>
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th>User</th>
                <th>Description</th>
                <th>Guest</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @isset($data['reservationList'])
            @foreach ($data['reservationList'] as $item)
                <tr>
                    <td>
                        <a class="uk-button uk-button-text" href="{{route('reservation.edit', $item->reservation_id)}}">
                            {{$item->person_firstname}} {{$item->person_lastname}}
                        </a>
                        
                        <p class="uk-text-meta uk-margin-remove-top">
                            {{$item->reservation_started_at}} - {{$item->reservation_ended_at}}
                        </p>
                    </td>
                    <td>{{$item->reservation_description}}</td>
                    <td>
                        {{$item->reservation_guest}}
                    </td>
                    <td></td>
                </tr>
            @endforeach
            @endisset
        </tbody>
    </table>
@isset($data['reservationList'])
@include('partial.paginationPartial', ['paginator' => $data['reservationList']])
@endisset





