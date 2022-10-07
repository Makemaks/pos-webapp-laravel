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
        @isset($reservationList)
        @foreach ($reservationList as $item)
        <tr>
            <td>
                <a class="uk-button uk-button-text" href="{{route('reservation.edit', $item->reservation_id)}}">
                    {{$item->User->UserPerson->person_name['person_firstname']}}
                    {{$item->User->UserPerson->person_name['person_lastname']}}
                </a>

                <p class="uk-text-meta uk-margin-remove-top">
                    {{$item->reservation_started_at}} - {{$item->reservation_ended_at}}
                </p>
            </td>
            <td>{{$item->reservation_description}}</td>
            <td>
                {{$item->reservation_guest}}
            </td>
            <td>
                <form action="{{route('reservation.destroy', $item->reservation_id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="uk-button uk-button-danger uk-border-rounded">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
        @endisset
    </tbody>
</table>
@isset($reservationList)
@include('partial.paginationPartial', ['paginator' => $reservationList])
@endisset
