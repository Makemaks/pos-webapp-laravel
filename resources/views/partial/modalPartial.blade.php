<!-- This is the modal -->
@php

$route = Str::before(Request::route()->getName(), '.');
$action = Str::after(Request::route()->getName(), '.');
// $model_id = $data['userModel']->user_id;

@endphp
<div id="modal-{{ $model_id }}" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title uk-text-danger">
            Are you sure?
        </h2>

        <div class="uk-grid-small" uk-grid>
            <div>
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            </div>

            <form id="delete-{{ $route }}-{{ $model_id }}"
                action="{{ route($route . '.destroy', $model_id) }}" method="POST">
                {{ csrf_field() }}
                {{ method_field('DELETE') }}
                <div>
                    <button class="uk-button uk-button-primary" type="submit"
                        form="delete-{{ $route }}-{{ $model_id }}">Confirm</button>
                </div>
            </form>

        </div>
    </div>
</div>
