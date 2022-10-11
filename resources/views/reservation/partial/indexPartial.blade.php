
<form action="{{route('reservation.store')}}" method="post">
    @csrf
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn">Save</button>
    <a class="uk-button uk-button-danger uk-border-rounded delete-btn">Delete</a>
<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th><input class="uk-checkbox reserve-checkbox" type="checkbox"></th>
            <th>User</th>
            <th>Description</th>
            <th>Quantity</th>
            <th>Note</th>
            <th>No Show Fee</th>
            <th>Deposit</th>
        </tr>
    </thead>
   
    <tbody>
        <div id="appendDelete" style="display: none"></div>
        @isset($reservationList)
        @foreach ($reservationList as $key => $item)
        <tr>
            <td><input class="uk-checkbox" type="checkbox" name="reservation[{{$key}}][checked_row]"></td>
            <td>
                <select class="uk-select" name="reservation[{{$key}}][reservation_user_id]">
                    @foreach($users as $user)
                        <option value="{{$user->user_id}}" {{ $user->user_id == $item->reservation_user_id ? 'selected' : '' }}>{{$user->UserPerson->person_name['person_firstname']}} {{$user->UserPerson->person_name['person_lastname']}}</option>
                    @endforeach
                </select>
                {{-- <a class="uk-button uk-button-text" href="{{route('reservation.edit', $item->reservation_id)}}">
                    {{$item->User->UserPerson->person_name['person_firstname']}}
                    {{$item->User->UserPerson->person_name['person_lastname']}}
                </a> --}}

                <p class="uk-text-meta uk-margin-remove-top">
                    {{$item->reservation_started_at}} - {{$item->reservation_ended_at}}
                </p>
            </td>
            <input class="uk-input" type="hidden" name="reservation[{{$key}}][reservation_id]" value="{{$item->reservation_id ?? ''}}">
            <td><input class="uk-input" type="text" name="reservation[{{$key}}][reservation_description]" value="{{$item->reservation_description ?? ''}}"></td>
            <td>
                <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_quantity]" value="{{$item->reservation_quantity ?? ''}}">
            </td>
            <td>
                <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_note]" value="{{$item->reservation_note ?? ''}}">
            </td>
            <td>
                <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_no_show_fee]" value="{{$item->reservation_no_show_fee ?? ''}}">
            </td>
            <td>
                <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_deposit]" value="{{$item->reservation_deposit ?? ''}}">
            </td>
            {{-- <td>
                <form action="{{route('reservation.destroy', $item->reservation_id)}}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="uk-button uk-button-danger uk-border-rounded">Delete</button>
                </form>
            </td> --}}
        </tr>
        @endforeach
        @endisset
    </tbody>
    </form>
</table>
@isset($reservationList)
@include('partial.paginationPartial', ['paginator' => $reservationList])
<script>
    $(document).on('click','.reserve-checkbox',function(){
        $(':checkbox').each(function () { this.checked = !this.checked; });
    });
    $(document).on('click','.delete-btn',function(){
        $('#appendDelete').append("<input type='text' name='is_delete_request' value='true'></td>");
        $('.save-btn').click();
    });
</script>
@endisset

