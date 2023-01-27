@php

    
    use App\Models\Receipt;
    use App\Models\Setting;

    $orderList = $data['orderList']->whereNotNull('order_setting_key')->groupBy('order_id');
  
    $flattened = $orderList->flatMap(function ($values) {
        return array_map(null, json_decode($values->first()->order_setting_key, true) );
    })->where('setting_key_group', $type)->groupBy('name');


@endphp


<h3 class="uk-card-title">{{Str::upper(Setting::SettingKeyGroup()[$type])}} KEY</h3>
<div class="uk-overflow-auto uk-height-large">
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            <thead>
                <tr>
                    {{-- @foreach ($setting_key[0] as $key => $item)
                        <th>{{ $key }}</th>
                    @endforeach --}}
                </tr>
            </thead>
            <tbody>
                @foreach ($flattened as $setting_key_key => $setting_key_value)
                    <tr>
                        
                            <td>{{ $setting_key_value->first()['name'] }}</td>
                            <td>{{ $setting_key_value->count() }}</td>
                            <td>{{ $setting_key_value->sum('value') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
</div>
