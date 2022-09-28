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
            disabled>{{ __('Delete') }}</button>

    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a id="tab-vouchers-list" href="#">{{Str::upper(Request::get('view'))}}</a></li>
        <li><a id="tab-voucher-item" href="#" uk-icon="plus"></a></li>
    </ul>

    @if($data['settingModel']->setting_id)
        <ul class="uk-switcher uk-margin">
            <li>
                <div>
                    @if (isset($data['settingModel']->setting_offer) && !empty($data['settingModel']->setting_offer))
                        @php
                        $voucher_count = 0;
                        @endphp
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
                                        <th>{{ __('Date start') }}</th>
                                        <th>{{ __('Date end') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Discount value') }}</th>
                                        <th>{{ __('Quantity') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach ($data['settingModel']->setting_offer as $setting_offer_key => $setting_offer)
                                    @if($setting_offer['boolean']['type'] != 0)
                                        @continue
                                    @endif
                                    @php $voucher_count++; @endphp
                                    <tr>
                                        <td>
                                            <input type="checkbox" name="setting_offer_delete_indexes[{{ $setting_offer_key }}]" onchange="document.getElementById('form-vouchers').querySelectorAll('input:checked').length > 0 ? document.getElementById('button-delete-vouchers').removeAttribute('disabled') : document.getElementById('button-delete-vouchers').setAttribute('disabled', 'disabled')">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{ $setting_offer_key }}</button>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][date][start_date]" class="uk-input uk-width-small" type="date" min="{{ date('Y-m-d') }}" value="{{ $setting_offer['date']['start_date'] ?? '' }}" required>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][date][end_date]" class="uk-input uk-width-small" type="date" min="{{ date('Y-m-d') }}" value="{{ $setting_offer['date']['end_date'] ?? '' }}" required>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][string][code]" class="uk-input uk-width-small" type="text" value="{{ $setting_offer['string']['code'] ?? '' }}" required>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][string][name]" class="uk-input uk-width-small" type="text" value="{{ $setting_offer['string']['name'] ?? '' }}" required>
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][decimal][discount_value]" class="uk-input" type="number" min="0" step="0.01" value="{{ $setting_offer['decimal']['discount_value'] ?? '' }}">
                                        </td>
                                        <td>
                                            <input name="setting_offer[{{ $setting_offer_key }}][integer][quantity]" class="uk-input" type="number" min="0" step="1" value="{{ $setting_offer['integer']['quantity'] ?? '' }}">
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
                            <label>{{ __('Start date') }}</label>
                            <input name="date[start_date]" class="uk-input" type="date" min="{{ date('Y-m-d') }}" value="{{ $setting_offer['date']['start_date'] ?? '' }}" required>
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('End date') }}</label>
                            <input name="date[end_date]" class="uk-input" type="date" min="{{ date('Y-m-d') }}" value="{{ $setting_offer['date']['end_date'] ?? '' }}" required>
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Code') }}</label>
                            <input name="string[code]" class="uk-input" type="text" value="{{ $setting_offer['string']['code'] ?? '' }}" required>
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Name') }}</label>
                            <input name="string[name]" class="uk-input" type="text" value="{{ $setting_offer['string']['name'] ?? '' }}" required>
                        </div>
                    </div>
                    <div uk-grid>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Discount value') }}</label>
                            <input name="decimal[discount_value]" class="uk-input" type="number" min="0" step="0.01" value="{{ $setting_offer['decimal']['discount_value'] ?? '' }}">
                        </div>
                        <div class="uk-form-width-medium">
                            <label>{{ __('Quantity') }}</label>
                            <input name="integer[quantity]" class="uk-input" type="number" min="0" step="1" value="{{ $setting_offer['integer']['quantity'] ?? '' }}">
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


