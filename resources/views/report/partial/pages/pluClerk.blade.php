@php
$dataModel = $data['orderList']->sortBy('user_id')->groupBy('user_id');

$title = $data['title'];
$table = $data['table'];

$arrays = [];

foreach ($data['settingModel']->setting_stock_group_category_plu as $key => $valueDepartment) {
    if ($valueDepartment['type'] == 2) {
        foreach ($dataModel as $user_id => $value) {
            foreach ($value as $key => $values) {
                $stock_merchandise = json_decode($values->stock_merchandise, true);

                if (array_key_exists($stock_merchandise['plu_id'], $arrays)) {
                    $arrays[$stock_merchandise['plu_id']] = [
                        'PLU' => $stock_merchandise['plu_id'],
                        'Name' => $stock_merchandise['stock_name'],
                        'Department' => $valueDepartment['description'],
                        'Quantity' => $arrays[$stock_merchandise['plu_id']]['Quantity'] + 1,
                        'Total' => App\Helpers\MathHelper::FloatRoundUp($arrays[$stock_merchandise['plu_id']]['Total'] + json_decode($values->stock_cost, true)[$stock_merchandise['plu_id']]['price'], 2),
                    ];
                } else {
                    $arrays[$stock_merchandise['plu_id']] = [
                        'PLU' => $stock_merchandise['plu_id'],
                        'Name' => $stock_merchandise['stock_name'],
                        'Department' => $valueDepartment['description'],
                        'Quantity' => 1,
                        'Total' => json_decode($values->stock_cost, true)[$stock_merchandise['plu_id']]['price'],
                    ];
                }
            }

            ksort($arrays);
            $array[$user_id] = [
                'Clerk' => json_decode($values->person_name)->person_firstname,
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
