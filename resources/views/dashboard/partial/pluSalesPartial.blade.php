@php
$table = 'pluSalesPartial';
$pluData = App\Models\Stock::GroupCategoryBrandPlu($data, 2);
@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body" style="height: 730px">
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
