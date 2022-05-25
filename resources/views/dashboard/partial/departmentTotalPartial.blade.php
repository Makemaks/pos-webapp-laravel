@php
$categoryData = App\Models\Stock::GroupCategoryBrandPlu($data, 1);
$table = 'departmentTotalPartial';
@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
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
        @include('document.button')
    </div>
</div>
