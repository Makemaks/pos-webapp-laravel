@php
use App\Models\Warehouse;
use App\Models\User;
use App\Models\Store;
$action = Str::after(Request::route()->getName(), '.');
@endphp

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>PLU</th>
            <th>CODE</th>
            <th>Description</th>
            <th>Frozen Stock</th>
            <th>Entered Stock</th>
            <th>Variance</th>
            <th>Avg Cost</th>
            <th>Variance Value</th>
            <th>Entered Stock Value</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>0</td>
            <td>0</td>
            <td></td>
            <td>{{$varianceData['frozen_stock'] ?? 0}}</td>
            <td>{{$varianceData['entered_stock'] ?? 0}}</td>
            <td>{{$varianceData['variance'] ?? 0}}</td>
            <td>0</td>
            <td>{{$varianceData['variance_value'] ?? 0}}</td>
            <td>{{$varianceData['entered_stock_value'] ?? 0}}</td> 
        </tr>
    </tbody>
    <input class="uk-checkbox" type="hidden" name="store_from_index">
    <div id="appendDelete" style="display: none"></div>
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn" style="display: none">Save</button>
</table>