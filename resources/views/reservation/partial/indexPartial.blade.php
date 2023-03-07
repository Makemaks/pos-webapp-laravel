<button class="uk-button uk-button-default uk-border-rounded uk-button-primary top-save-btn">Save</button>
<a class="uk-button uk-button-danger uk-border-rounded delete-btn">Delete</a>
<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li>
        <a href="#">
            Reservation
        </a>
    </li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>
<ul class="uk-switcher uk-margin">
    <li>
        <form action="{{route('reservation.store')}}" method="post">
            @csrf
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
                                <option value="{{$user->user_id}}"
                                    {{ $user->user_id == $item->reservation_user_id ? 'selected' : '' }}>
                                    {{$user->UserPerson->person_name['person_firstname']}}
                                    {{$user->UserPerson->person_name['person_lastname']}}</option>
                                @endforeach
                            </select>
                            <p class="uk-text-meta uk-margin-remove-top">
                                {{$item->reservation_started_at}} - {{$item->reservation_ended_at}}
                            </p>
                        </td>
                        <input class="uk-input" type="hidden" name="reservation[{{$key}}][reservation_id]"
                            value="{{$item->reservation_id ?? ''}}">
                        <td><input class="uk-input" type="text" name="reservation[{{$key}}][reservation_description]"
                                value="{{$item->reservation_description ?? ''}}"></td>
                        <td>
                            <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_quantity]"
                                value="{{$item->reservation_quantity ?? ''}}">
                        </td>
                        <td>
                            <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_note]"
                                value="{{$item->reservation_note ?? ''}}">
                        </td>
                        <td>
                            <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_no_show_fee]"
                                value="{{$item->reservation_no_show_fee ?? ''}}">
                        </td>
                        <td>
                            <input class="uk-input" type="text" name="reservation[{{$key}}][reservation_deposit]"
                                value="{{$item->reservation_deposit ?? ''}}">
                        </td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
            </table>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn" style="display: none">Save</button>
        </form>
    </li>
    <li>
        <form action="{{route('reservation.store')}}" method="post">
            @csrf
            <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
            <div class="uk-container uk-container-xsmall">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend"></legend>
                    <div class="uk-margin">
                        <label for="">Choose User</label>
                        <select class="uk-select" name="reservation_user_id">
                            @foreach($users as $user)
                            <option value="{{$user->user_id}}">{{$user->UserPerson->person_name['person_firstname']}}
                                {{$user->UserPerson->person_name['person_lastname']}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="uk-margin">
                        <label for="">Description</label>
                        <textarea class="uk-textarea" rows="5" placeholder="Textarea"
                            name="reservation_description"></textarea>
                    </div>

                    <div class="uk-margin">
                        <label for="">Quantity</label>
                        <input class="uk-input" type="number" min="0" name="reservation_quantity" value="">
                    </div>
                    <div class="uk-margin">
                        <label for="">Note</label>
                        <input class="uk-input" type="text" name="reservation_note" value="">
                    </div>
                    <div class="uk-margin">
                        <label for="">No show fee</label>
                        <input class="uk-input" step="0.01" type="number" name="reservation_no_show_fee" value="">
                    </div>
                    <div class="uk-margin">
                        <label for="">Deposit</label>
                        <input class="uk-input" step="0.01" type="number" name="reservation_deposit" value="">
                    </div>
                </fieldset>
            </div>
        </form>
    </li>
</ul>

@isset($reservationList)
@include('partial.paginationPartial', ['paginator' => $reservationList])
<script>
    $(document).on('click', '.reserve-checkbox', function () {
        $(':checkbox').each(function () {
            this.checked = !this.checked;
        });
    });
    $(document).on('click', '.delete-btn', function () {
        $('#appendDelete').append("<input type='text' name='is_delete_request' value='true'></td>");
        $('.save-btn').click();
    });
    $(document).on('click','.top-save-btn', function() {
        $('.save-btn').click();
    });
</script>
@endisset
