<div id="modal-setting-{{ $data['settingModel']->setting_id }}-setting_offer" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title uk-text-danger">
            {{ __('Are you sure?') }}
        </h2>

        <div class="uk-grid-small" uk-grid>
            <div>
                <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            </div>

            <div>
                <button class="uk-button uk-button-primary uk-modal-close" type="button" onclick="document.getElementById('form-multidelete-vouchers').submit();">Confirm</button>
            </div>
        </div>
    </div>
</div>
