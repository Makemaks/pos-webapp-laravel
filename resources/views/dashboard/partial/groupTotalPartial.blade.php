@php
$table = 'groupTotalPartial';
$groupData = App\Models\Stock::GroupCategoryBrandPlu($data, 0);
@endphp
<div>
    <div class="uk-card uk-card-default uk-card-body">
        <h3 class="uk-card-title">GROUP SALES TOTAL</h3>

        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    <th>Department</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($groupData as $key => $item)
                    <tr>
                        <td>{{ $item['description'] }}</td>
                        <td>{{ $item['Quantity'] }}</td>
                        <td>{{ $item['Total'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</div>
