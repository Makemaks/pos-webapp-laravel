@php
     use App\Helpers\NumpadHelper;
@endphp


<div id="modal-center" class="uk-flex-top" uk-modal>
    <div class="uk-modal-dialog uk-modal-body uk-margin-auto-vertical">

        <button class="uk-modal-close-default" type="button" uk-close></button>

        <div class="uk-margin">
            <input class="uk-input uk-form-width-expand" type="text" placeholder="" autofocus id="barcodeinputID" onchange="GetInput(this)">
        </div>

        @for ($i = 0; $i < count(NumpadHelper::Numpad()[0]); $i++)
            
            <div class="uk-margin-small">
                <div class="uk-grid-small uk-child-width-expand uk-text-center uk-button" uk-grid>
                    @for ($j = 0; $j < count(NumpadHelper::Numpad()[0][$i]); $j++)
                        
                            <div>
                                <div class="uk-padding-small uk-background-muted uk-border-rounded numpad" onclick="numpad(this)">
                                    {{ NumpadHelper::Numpad()[0][$i][$j]}}
                                </div>
                            </div>
                    @endfor
                </div>
            </div>

        @endfor

    </div>
</div>




