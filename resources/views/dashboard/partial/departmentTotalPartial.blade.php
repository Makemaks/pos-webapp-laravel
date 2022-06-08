@php
$categoryData = App\Models\Stock::GroupCategoryBrandPlu($data, 1, 'category_id');

@endphp
<div>
    <h3 class="uk-card-title">DEPARTMENT TOTAL</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categoryData as $key => $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['Quantity'] }}</td>
                        <td>{{ $item['Total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
