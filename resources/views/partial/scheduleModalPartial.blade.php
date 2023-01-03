<!-- This is the modal -->
@php

$route = Str::before(Request::route()->getName(), '.');
$action = Str::after(Request::route()->getName(), '.');
// $model_id = $data['userModel']->user_id;

@endphp
<div id="schedule-{{ $route }}" uk-modal>
    {{-- <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title uk-text-primary">
                Schedule Changes for {{Str::upper($route)}}
            </h2>
        </div>
        <div class="uk-modal-body">
            <div uk-grid>
                <form class="uk-form-horizontal uk-margin-large">

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-horizontal-text">Date:</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-horizontal-text" type="text" placeholder="22/12/2022">
                        </div>
                    </div>

                    <div class="uk-margin">
                        <label class="uk-form-label" for="form-horizontal-text">Time:</label>
                        <div class="uk-form-controls">
                            <input class="uk-input" id="form-horizontal-text" type="text" placeholder="00:00">
                        </div>
                    </div>
                    
                    <div class="uk-modal-footer uk-text-right">
                        <button class="uk-button uk-button-success" type="submit">Set Schedule</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
    <div class="uk-modal-dialog">
        <button class="uk-modal-close-default" type="button" uk-close></button>
        <div class="uk-modal-header">
            <h2 class="uk-modal-title">Schedule Changes for {{Str::upper($route)}}</h2>
        </div>
        <div class="uk-modal-body">
            <form class="uk-form-horizontal uk-margin-large" action="" method="post">
                @csrf
                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Date:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text" placeholder="22/12/2022">
                    </div>
                </div>

                <div class="uk-margin">
                    <label class="uk-form-label" for="form-horizontal-text">Time:</label>
                    <div class="uk-form-controls">
                        <input class="uk-input" id="form-horizontal-text" type="text" placeholder="00:00">
                    </div>
                </div>
                
                {{-- <div class="uk-modal-footer uk-text-right">
                    <button class="uk-button uk-button-success" type="submit">Set Schedule</button>
                </div> --}}
            </form>
        </div>
        <div class="uk-modal-footer uk-text-right">
            <button class="uk-button uk-button-primary" type="submit">Set Schedule</button>
        </div>
    </div>
</div>
