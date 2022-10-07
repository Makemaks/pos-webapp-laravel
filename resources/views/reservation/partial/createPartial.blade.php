<form action="{{route('reservation.store')}}" method="post">
    @csrf
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
    <div class="uk-container uk-container-xsmall">
        <fieldset class="uk-fieldset">
    
            <legend class="uk-legend"></legend>
        
            {{-- <div class="uk-margin">
                <label for="">Guest</label>
                <input class="uk-input" type="text"  name="reservation_guest" value="">
            </div> --}}
            <div class="uk-margin">
                <label for="">Choose User</label>
                <select class="uk-select" name="reservation_user_id">
                    @foreach($users as $user)
                        <option value="{{$user->user_id}}">{{$user->UserPerson->person_name['person_firstname']}} {{$user->UserPerson->person_name['person_lastname']}}</option>
                    @endforeach
                </select>
            </div>

            <div class="uk-margin">
                <label for="">Description</label>
                <textarea class="uk-textarea" rows="5" placeholder="Textarea" name="reservation_description"></textarea>
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
