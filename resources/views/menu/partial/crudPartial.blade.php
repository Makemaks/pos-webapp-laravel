<div class="uk-margin">
    @if ($data['settingModel']->edit == false)
    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
        Save
    </button>
    @endif

    <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingDelete" name="settingDelete">
        Delete
    </button>
</div>