

<input type="text" id="barcodeInputID" hidden>
<div class="uk-child-width-1-2" uk-grid>
    <div>
        <h3 class="uk-margin-remove-bottom" id="useCustomerID">
            @isset($data['personModel'])
                @include('person.partial.personPartial')
            @endisset
        </h3>
    </div>
    <div>
        <div class="uk-align-right">
            <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="control(0)" uk-icon="pencil" id="controlShowID"></button>
            <button type="button" class="uk-button uk-button-default uk-border-rounded" onclick="control(1)" uk-icon="close" id="controlHideID" hidden></button>
        </div>
    </div>
</div>


