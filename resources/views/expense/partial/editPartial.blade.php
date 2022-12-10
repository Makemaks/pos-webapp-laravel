<form action="{{route('reservation.update',$reservation->reservation_id)}}" method="post">
    @csrf
    @method('PUT')
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
<div class="uk-container uk-container-xsmall">
    <fieldset class="uk-fieldset">

        <legend class="uk-legend"></legend>
    
        <div class="uk-margin">
            <label for="">Choose User</label>
            <select class="uk-select" name="reservation_user_id">
                @foreach($users as $user)
                    <option value="{{$user->user_id}}" {{ $user->user_id == $reservation->reservation_user_id ? 'selected' : '' }}>{{$user->UserPerson->person_name['person_firstname']}} {{$user->UserPerson->person_name['person_lastname']}}</option>
                @endforeach
            </select>
        </div>
    
        <div class="uk-margin">
            <label for="">Description</label>
            <textarea class="uk-textarea" rows="5" placeholder="Textarea" name="reservation_description">{{$reservation->reservation_description ?? ''}}</textarea>
        </div>

        <div class="uk-margin">
            <label for="">Quantity</label>
            <input class="uk-input" type="text" name="reservation_quantity" value="{{$reservation->reservation_quantity ?? ''}}">
        </div>
        <div class="uk-margin">
            <label for="">Note</label>
            <input class="uk-input" type="text" name="reservation_note" value="{{$reservation->reservation_note ?? ''}}">
        </div>
        <div class="uk-margin">
            <label for="">No show fee</label>
            <input class="uk-input" type="text" name="reservation_no_show_fee" value="{{$reservation->reservation_no_show_fee ?? ''}}">
        </div>
        <div class="uk-margin">
            <label for="">Deposit</label>
            <input class="uk-input" type="text" name="reservation_deposit" value="{{$reservation->reservation_deposit ?? ''}}">
        </div>
    </fieldset>
    
</div>
</form>