@extends('layout.master')

@section('content')
    <button type="submit"
            form="form-vouchers"
            value="voucherUpdate"
            name="voucherUpdate"
            id="button-update-vouchers"
            class="uk-button uk-button-danger uk-border-rounded"
    >{{ __('Save') }}</button>
    <button type="submit"
            form="form-vouchers"
            value="voucherDelete"
            name="voucherDelete"
            id="button-delete-vouchers"
            class="uk-button uk-button-danger uk-border-rounded"
    >{{ __('Delete') }}</button>

    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a id="tab-vouchers-list" href="#">{{Str::upper(Request::get('view'))}}</a></li>
        <li><a id="tab-voucher-item" href="#" uk-icon="plus"></a></li>
    </ul>

    @if($data['settingModel']->setting_id)
        <ul class="uk-switcher uk-margin">
            <li>
                <div>
                    @if (isset($data['settingModel']->setting_offer) && !empty($data['settingModel']->setting_offer))
                        <form id="form-vouchers" action="{{ route('setting.update', ['setting' => $data['settingModel']->setting_id]) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="resource_type" value="voucher">
                            <input type="hidden" name="setting_id" value="{{ $data['settingModel']['setting_id'] }}">
                            <input type="hidden" name="boolean[type]" value="0">
                            <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('REF') }}</th>
                                        <th>{{ __('Start Date') }}</th>
                                        <th>{{ __('End Date') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Barcode') }}</th>
                                        <th>{{ __('Description') }}</th>
                                        <th>{{ __('Gain') }}</th>
                                        <th>{{ __('Collect') }}</th>
                                        <th>{{ __('Discount value') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                        <th>{{ __('Per usage') }}</th>
                                        <th>{{ __('Per person') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data['settingModel']->setting_offer as $setting_offer_key => $setting_offer)
                                    @if($setting_offer['boolean']['type'] != 0)
                                        @continue
                                    @endif
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_offer_delete_indexes[{{ $setting_offer_key }}]">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{ $setting_offer_key }}</button>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][date][start_date]" class="uk-input uk-width-small" type="date" value="{{ $setting_offer['date']['start_date'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][date][end_date]" class="uk-input uk-width-small" type="date" value="{{ $setting_offer['date']['end_date'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][string][code]" class="uk-input uk-width-small" type="text" value="{{ $setting_offer['string']['code'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][string][name]" class="uk-input uk-width-small" type="text" value="{{ $setting_offer['string']['name'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][string][barcode]" class="uk-input uk-width-small" type="text" value="{{ $setting_offer['string']['barcode'] ?? '' }}">
                                        </td>
                                        <td>
                                            <textarea name="setting_offer[{{ $setting_offer_key }}][string][description]" class="uk-textarea uk-width-medium">{{ $setting_offer['string']['description'] ?? '' }}</textarea>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][decimal][gain]" class="uk-input uk-width-small" type="number" value="{{ $setting_offer['decimal']['gain'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][decimal][collect]" class="uk-input uk-width-small" type="number" value="{{ $setting_offer['decimal']['collect'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][decimal][discount_value]" class="uk-input uk-width-small" type="number" value="{{ $setting_offer['decimal']['discount_value'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][integer][quantity]" class="uk-input uk-width-small" type="number" value="{{ $setting_offer['integer']['quantity'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][usage][per_usage]" class="uk-input uk-width-small" type="number" value="{{ $setting_offer['usage']['per_usage'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][usage][per_person]" class="uk-input uk-width-small" type="number" value="{{ $setting_offer['usage']['per_person'] ?? '' }}">
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                    @else
                        <div class="uk-alert-danger">
                            <h3>{{ __('Vouchers not found') }}</h3>
                        </div>
                    @endif
                </div>
            </li>

            <li>
                <form action="{{ route('setting.store') }}" method="POST" class="uk-padding uk-padding-small">
                    @csrf
                    <input type="hidden" name="resource_type" value="voucher">
                    <input type="hidden" name="setting_id" value="{{ $data['settingModel']['setting_id'] }}">
                    <input type="hidden" name="boolean[type]" value="0">
                    @php
                        $setting_offer = [];
                        if (request()->old() && request()->old('resource_type') == 'voucher') {
                            $setting_offer = request()->old();
                        }
                    @endphp
                    @if($errors && $errors->all())
                        <ul class="uk-alert-danger" uk-alert>
                            <a class="uk-alert-close" uk-close></a>
                            <h4>{{ __('Errors') }}</h4>
                            @foreach ($errors->all() as $error)
                                <li class="uk-text-danger">{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Start Date') }}</label>
                            <input name="date[start_date]" class="uk-input" type="date" value="{{ $setting_offer['date']['start_date'] ?? '' }}">
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('End Date') }}</label>
                            <input name="date[end_date]" class="uk-input" type="date" value="{{ $setting_offer['date']['end_date'] ?? '' }}">
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Code') }}</label>
                            <input name="string[code]" class="uk-input" type="text" value="{{ $setting_offer['string']['code'] ?? '' }}">
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Name') }}</label>
                            <input name="string[name]" class="uk-input" type="text" value="{{ $setting_offer['string']['name'] ?? '' }}">
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Barcode') }}</label>
                            <input name="string[barcode]" class="uk-input" type="text" value="{{ $setting_offer['string']['barcode'] ?? '' }}">
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-large">
                            <label>{{ __('Description') }}</label>
                            <textarea name="string[description]" class="uk-textarea">{{ $setting_offer['string']['description'] ?? '' }}</textarea>
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Gain') }}</label>
                            <input name="decimal[gain]" class="uk-input" type="number" value="{{ $setting_offer['decimal']['gain'] ?? '' }}">
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Collect') }}</label>
                            <input name="decimal[collect]" class="uk-input" type="number" value="{{ $setting_offer['decimal']['collect'] ?? '' }}">
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Discount value') }}</label>
                            <input name="decimal[discount_value]" class="uk-input" type="number" value="{{ $setting_offer['decimal']['discount_value'] ?? '' }}">
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Quantity') }}</label>
                            <input name="integer[quantity]" class="uk-input" type="number" value="{{ $setting_offer['integer']['quantity'] ?? '' }}">
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Per usage') }}</label>
                            <input name="usage[per_usage]" class="uk-input" type="number" value="{{ $setting_offer['usage']['per_usage'] ?? '' }}">
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Per person') }}</label>
                            <input name="usage[per_person]" class="uk-input" type="number" value="{{ $setting_offer['usage']['per_person'] ?? '' }}">
                        </div>
                    </div>

                    <div class="uk-margin-medium-top">
                        <div>
                            <button class="uk-button uk-button-primary uk-border-rounded" type="submit">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            </li>
        </ul>
    @else
        <div class="uk-alert-danger">
            <h3>{{ __('Setting not found') }}</h3>
        </div>
    @endif
@endsection


