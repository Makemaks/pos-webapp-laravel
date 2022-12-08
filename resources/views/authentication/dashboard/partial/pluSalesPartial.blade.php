@php
$table = 'pluSalesPartial';
$pluData = App\Models\Stock::GroupCategoryBrandPlu($data, 2, 'plu_id');
@endphp
<div>
    <h3 class="uk-card-title">PLU SALES TOTAL</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pluData as $key => $item)
                    <tr>
                        <td>{{ $item['name'] }}</td>
                        <td>{{ $item['Quantity'] }}</td>
                        <td>{{ $item['Total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
