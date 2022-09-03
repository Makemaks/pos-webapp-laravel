<div uk-grid>
    <div>
        <label class="uk-form-label" for="form-stacked-text">Code</label>
        <input name="code" class="uk-input" type="number" placeholder="Code" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_group']['code'] : ''}}">
    </div>

    <div>
        <label class="uk-form-label" for="form-stacked-text">Name</label>
        <input name="name" class="uk-input" type="text" placeholder="Name" value="{{$data['settingModel']['edit'] ? $data['settingModel']['setting_stock_group']['name'] : ''}}">
    </div>
    
    <div>
        @if($data['settingModel']['edit'])
            <input name="index" class="uk-input" type="hidden" value="{{ request("index") }}">
        @else 
            <input name="type" class="uk-input" type="hidden" value="{{Session::get('type')}}">
            <input name="setting_id" class="uk-input" type="hidden" value="{{$data['settingModel']->setting_id}}">
        @endif
    </div>
</div>

<div class="uk-margin-medium-top">
    <div>
        <label class="uk-form-label" for="form-stacked-text"></label>
        <button class="uk-button uk-button-default uk-border-rounded" type="submit">
            Submit
        </button>
    </div>
</div>