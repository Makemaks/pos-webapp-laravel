@extends('layout.master')

@section('content')
    <ul class="uk-subnav uk-subnav-pill" uk-switcher>
        <li><a id="tab-vouchers-list" href="#">{{Str::upper(Request::get('view'))}}</a></li>
        <li><a id="tab-voucher-item" href="#" uk-icon="plus"></a></li>
    </ul>

    <ul class="uk-switcher uk-margin">
        <li>
            <div>
                @if($data['settingModel']->setting_id)
                    @if (isset($data['settingModel']->setting_offer) && !empty($data['settingModel']->setting_offer))
                        @php
                        $voucher_count = 0;
                        @endphp
                        <form id="form-multidelete-vouchers" action="{{ route('setting.destroy', ['setting' => $data['settingModel']->setting_id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="resource_type" value="voucher">
                            <table class="uk-table uk-table-divider uk-table-small uk-table-responsive">

                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>{{ __('REF') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Code') }}</th>
                                        <th>{{ __('Name') }}</th>
                                        <th>{{ __('Barcode') }}</th>
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
                                            <input type="checkbox" name="setting_offer_indexes[{{ $setting_offer_key }}]" onchange="document.getElementById('form-multidelete-vouchers').querySelectorAll('input:checked').length > 0 ? document.getElementById('button-multidelete-vouchers').removeAttribute('disabled') : document.getElementById('button-multidelete-vouchers').setAttribute('disabled', 'disabled')">
                                        </td>
                                        <td>
                                            <button class="uk-button uk-button-default uk-border-rounded">{{ $setting_offer_key }}</button>
                                        </td>
                                        <td>
                                            <ul>
                                                <li>{{ __('FROM') }}: {{ $setting_offer['date']['start_date'] }}</li>
                                                <li>{{ __('TO') }}: {{ $setting_offer['date']['end_date'] }}</li>
                                            </ul>
                                        </td>
                                        <td>
                                            {{ $setting_offer['string']['code'] }}
                                        </td>
                                        <td>
                                            {{ $setting_offer['string']['name'] }}
                                        </td>
                                        <td>
                                            {{ $setting_offer['string']['barcode'] }}
                                        </td>
                                        <td>
                                            {{ number_format($setting_offer['decimal']['discount_value'], 2, '.', '') }}
                                        </td>
                                        <td>
                                            {{ $setting_offer['integer']['quantity'] }}
                                        </td>
                                        <td>
                                            <div class="uk-width-auto">
                                                <a class="uk-button uk-button-default uk-border-rounded" uk-icon="icon: pencil" href="{{ route('setting.edit', ['setting' => $data['settingModel']->setting_id,  'index' => $setting_offer_key, 'resource_type' => 'voucher']) }}"></a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @if($voucher_count)
                                <button type="button"
                                        id="button-multidelete-vouchers"
                                        class="uk-button uk-button-danger"
                                        uk-toggle="target: #modal-setting-{{ $data['settingModel']->setting_id }}-setting_offer"
                                        uk-icon="icon: trash" disabled></button>
                            @endif
                        </form>
                        @if($voucher_count)
                            @include('menu.setting.vouchers.deleteConfirmation')
                        @endif
                    @else
                        <div class="uk-alert-danger">
                            <h3>{{ __('Vouchers not found') }}</h3>
                        </div>
                    @endif
                @else
                    <div class="uk-alert-danger">
                        <h3>{{ __('Setting not found') }}</h3>
                    </div>
                @endif
            </div>
        </li>

        <li>
            <form action="{{ route('setting.store') }}" method="POST" class="uk-padding uk-padding-small">
                @csrf
                @include('menu.setting.vouchers.item')
            </form>
        </li>
    </ul>
@endsection


