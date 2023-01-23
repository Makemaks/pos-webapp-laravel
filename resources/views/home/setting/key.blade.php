
<div class="uk-child-width-1-4@s uk-child-width-1-5@l uk-grid-small" uk-grid>

    @foreach (KeyHelper::Type()[ $key ]  as $key_setting_key_type  => $item_setting_key_type)
        <div>
            <div class="uk-box-shadow-small uk-padding-small" value="{{$key_setting_key_type}}" @if($key_setting_key_type == $valueItemSettingKey) selected @endif>
                {{$item_setting_key_type}}
            </div>
        </div>
    @endforeach
</div>                             

