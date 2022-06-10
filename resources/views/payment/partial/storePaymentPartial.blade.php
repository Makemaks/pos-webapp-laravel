<div class="uk-margin uk-align-center" uk-spinner ></div>

<form action="{{ route('receipt.store') }}" id="setup-in-store" method="POST">
    @csrf
    <input type="text" name="receipt_user_id" value="{{$receipt_user_id}}" hidden>
</form>


<div uk-margin>
    <button form="setup-in-store" type="submit" class="uk-button uk-button-default uk-border-rounded uk-width-expand" value="Declined">Declined</button>
    <button form="setup-in-store" type="submit" class="uk-button uk-button-default uk-border-rounded uk-button-danger uk-width-expand" value="Accepted">Accepted</button>
</div>