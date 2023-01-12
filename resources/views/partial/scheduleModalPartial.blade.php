<div id="schedule-{{ $view }}" uk-modal>
    <div class="uk-modal-dialog">
        
        {{-- <form class="uk-form-horizontal uk-margin-large" action="{{route('schedule')}}" method="post"> --}}
            {{-- @csrf --}}
            <button class="uk-modal-close-default" type="button" uk-close></button>
            <div class="uk-modal-header">
                <h2 class="uk-modal-title">Schedule Changes for {{($action != null) ? (Str::upper($action.' '.$view)) : (Str::upper($view))}}</h2>
            </div>
            <div class="uk-modal-body">
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Date:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text" name="date" placeholder="22/12/2022">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Time:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text" name="time" placeholder="00:00">
                    </div>
                </div>
            </div>
            <div class="uk-modal-footer uk-text-right">
                <button class="uk-button uk-button-primary" type="submit" form="accountUpdate" value="accountUpdate">Set Schedule</button>
            </div>
        {{-- </form> --}}
    </div>
</div>
