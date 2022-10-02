<div>
    <div>
        <div class="uk-card uk-card-default uk-padding">

            @if ($data['settingModel']->edit == false)
                <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
                    Save
                </button>
            @endif

            <button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingDelete" name="settingDelete">
                Delete
            </button>


            <ul class="uk-subnav uk-subnav-pill" uk-switcher>
                <li><a href="#" uk-icon="list"></a></li>
                <li><a href="#" uk-icon="plus"></a></li>
            </ul>

            <ul class="uk-switcher uk-margin">
                @if ($data['settingModel']->setting_reason && $data['settingModel']->edit == false)
                    <li>
                        <form id="settingUpdate" action="{{ route('setting.update', $data['settingModel']->setting_id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <h3>Reasons</h3>

                            <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>REF</th>
                                        <th>NAME</th>
                                        <th>SETTING STOCK GROUP</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data['settingModel']->setting_reason as $setting_reason_key => $setting_reason_item)
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="setting_reason_delete[]" value="{{ $setting_reason_key }}">
                                            </td>
                                            <td>
                                                <button type="button" class="uk-button uk-button-default uk-border-rounded">{{ $setting_reason_key }}</button>
                                            </td>
                                            <td>
                                                <input name="setting_reason[{{ $setting_reason_key }}][name]" class="uk-input" type="text" value="{{ $setting_reason_item['name'] ?? '' }}">
                                            </td>
                                            <td>
                                                <select class="uk-select" id="form-stacked-select" name="setting_reason[{{ $setting_reason_key }}][setting_stock_group]">
                                                    <option value="" selected disabled>SELECT ...</option>
                                                    @foreach ($data['settingModel']->setting_stock_group  as $setting_stock_group_key  => $setting_stock_group_item)
                                                        <option value="{{ $setting_stock_group_key }}" {{ isset($setting_reason_item['setting_stock_group']) && $setting_stock_group_key == $setting_reason_item['setting_stock_group'] ? 'selected' : '' }}>
                                                            {{ $setting_stock_group_item['name'] }}
                                                        </option>
                                                     @endforeach
                                                </select>
                                            </td>
                                        </tr>
                                 @endforeach
                                </tbody>
                            </table>
                        </form>
                    </li>
                @endif
                <li>
                    <form action="{{ route('setting.store') }}" method="POST">
                        <div class="uk-child-width-1-2" uk-grid>
                            @csrf
                            <input name="setting_id" class="uk-input" type="hidden" value="{{ $data['settingModel']->setting_id }}">
                            <div>
                                <label class="uk-form-label" for="setting_reason_name">NAME</label>
                                <input name="setting_reason[name]" id="setting_reason_name" class="uk-input" type="text" value="">
                            </div>
                            <div>
                                <label class="uk-form-label" for="setting_reason_setting_stock_group">SETTING STOCK GROUP</label>
                                <select class="uk-select" id="setting_reason_setting_stock_group" name="setting_reason[setting_stock_group]">
                                    <option value="" selected disabled>SELECT ...</option>
                                    @foreach ($data['settingModel']->setting_stock_group  as $setting_stock_group_key => $setting_stock_group_item)
                                        <option value="{{ $setting_stock_group_key }}">
                                            {{ $setting_stock_group_item['name'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="uk-child-width-expand" uk-grid>
                            <div>
                                <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-primary" type="submit">
                                    SAVE
                                </button>
                            </div>
                        </div>
                    </form>
                </li>
            </ul>

        </div>
    </div>
</div>
