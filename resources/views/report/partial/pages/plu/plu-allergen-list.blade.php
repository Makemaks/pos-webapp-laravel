<div>
    <h3 class="uk-card-title">Allergen Plu list</h3>
        <table class="uk-table uk-table-small uk-table-divider uk-table-responsive scroll">
            <thead>
                <tr>
                    <th>PLU</th>
                    <th>Name</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data['allergen_plu_data'] as $key => $item)
                    <tr>
                        <td>{{ $item['plu_id'] }}</td>
                        <td>{{ $item['plu_name'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
</div>
@isset($route)
<form action="{{ route($route . '.index') }}" method="GET">
<input type="hidden" name="isdownload" value="true">
<input type="hidden" name="fileName" value="{{Request::get('fileName')}}">
<input type="hidden" name="format" value="pdf">

<button class="uk-button uk-button-default uk-border-rounded" type="submit">
    PDF
</button>
<button class="uk-button uk-button-default uk-border-rounded" type="submit">
    CSV
</button>
</form>
@endisset