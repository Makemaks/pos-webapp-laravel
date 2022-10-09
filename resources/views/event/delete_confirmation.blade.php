<div id="modal-event-{{ $resource_id }}" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title uk-text-danger">
            {{ __('Are you sure?') }}
        </h2>

        <div class="uk-grid-small" uk-grid>
            <div>
                <button class="uk-button uk-button-default uk-modal-close" type="button">{{ __('Cancel') }}</button>
            </div>

            <form id="delete-event-{{ $resource_id }}" action="{{ route($route_name, [$resource_id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <div>
                    <button type="submit"
                            class="uk-button uk-button-danger"
                            form="delete-event-{{ $resource_id }}"
                    >{{ __('Confirm') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
