@php
$dataModel = $data['orderList'];

$title = $data['title'];
$table = $data['table'];

$arrays = [];

foreach ($data['settingModel']->setting_stock_group as $key => $setting_stock_group) {
    if ($setting_stock_group['type'] == 2) {
        foreach ($dataModel as $user => $userList) {
            foreach ($userList as $userListKey => $userListItem) {
                $stock_merchandise = json_decode($userList->stock_merchandise, true);
                $arrays[$stock_merchandise['plu_id']] = ['Quantity' => 0, 'Total' => 0];
                $arrays[$stock_merchandise['plu_id']] = [
                    'REF' => $stock_merchandise['plu_id'],
                    'Name' => $stock_merchandise['stock_name'],
                    'Group' => $setting_stock_group['name'],
                    'Quantity' => $arrays[$stock_merchandise['plu_id']]['Quantity'] + 1,
                    'Total' => App\Helpers\MathHelper::FloatRoundUp($arrays[$stock_merchandise['plu_id']]['Total'] + $userList->receipt_stock_cost , 2),
                ];
            }

            ksort($arrays);
            $array[$user] = [
                'Clerk' => json_decode($userList->person_name)->person_firstname,
                'Data' => $arrays,
            ];
        }
    }
}

@endphp

@if ($dataModel->count() > 0)
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    @include('document.button')
    <div class="uk-margin-top">
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
            @foreach ($array as $key => $item)
                <thead>
                    <tr>
                        <th>CLERK</th>
                        <th>PLU</th>
                        <th>Stock</th>
                        <th>Department</th>
                        <th>Quantity</th>
                        <th>Value</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($item['Data'] as $key => $value)
                        <tr>
                            @if ($loop->first)
                                <td style="font-weight: 700">{{ $item['Clerk'] }}</td>
                            @else
                                <td></td>
                            @endif
                            @foreach ($value as $key => $values)
                                <td>{{ $values }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            @endforeach
        </table>
    </div>
@else
    <div class="uk-margin-top">
        <h1 style="text-transform:capitalize; font-size:22px;">{{ $title }}</h1>
    </div>
    <div class="uk-alert-danger uk-border-rounded" uk-alert>
        <a class="uk-alert-close" uk-close></a>
        <p>No data to display.</p>
    </div>
@endif
