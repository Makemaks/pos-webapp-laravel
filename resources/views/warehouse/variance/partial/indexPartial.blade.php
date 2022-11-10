@php
    use App\Models\Warehouse;
    use App\Models\Store;
@endphp
<button class="uk-button uk-button-default uk-border-rounded uk-button-primary top-save-btn">Save</button>
<a class="uk-button uk-button-danger uk-border-rounded delete-btn">Delete</a>
<form action="{{route('warehouse.store')}}" method="post">
    @csrf
<table class="uk-table uk-table-small uk-table-divider">
  
    <thead>
        <tr>
            <th><input class="uk-checkbox reserve-checkbox" type="checkbox"></th>
            <th>StockTake ID</th>
            <th>StockeTake Sheet ID</th>
            <th>Reference</th>
            <th>Date</th>
            <th>Notes</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['warehouseList']->latest()->paginate(20) as $key => $warehouse)
        <tr>
            <td><input class="uk-checkbox" type="checkbox" name="warehouse[{{$key}}][checked_row]"></td>
                <input class="uk-checkbox" type="hidden" name="warehouse[{{$key}}][warehouse_id]" value="{{$warehouse->warehouse_id}}">
            <td><a href="{{route('warehouse.edit', $warehouse->warehouse_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$warehouse->warehouse_id}}</a></td>
            <td>{{$key}}</td>
            <td>oct</td>
            <td>{{$warehouse->created_at}}</td>
            <td></td>
            <td></td>
        </tr>
        @endforeach
    </tbody>
    <input class="uk-checkbox" type="hidden" name="store_from_index">
    <div id="appendDelete" style="display: none"></div>
    <button class="uk-button uk-button-default uk-border-rounded uk-button-primary save-btn" style="display: none">Save</button>
</table>
</form>

<script>
    $(document).on('click', '.delete-btn', function () {
        $('#appendDelete').append("<input type='text' name='is_delete_request' value='true'>");
        $('.save-btn').click();
    });
    $(document).on('click', '.reserve-checkbox', function () {
        $(':checkbox').each(function () {
            this.checked = !this.checked;
        });
    });
    $(document).on('click','.top-save-btn', function() {
        $('.save-btn').click();
    });
</script>







