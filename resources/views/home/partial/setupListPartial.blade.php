
@php
    use App\Models\User;    
@endphp

<div class="uk-child-width-1-2" uk-grid>
    <div>
        <h3>{{Str::ucfirst(Session::get('type'))}}</h3>
    </div>
    <div>
        <button class="uk-button uk-button-default uk-border-rounded uk-align-right" type="button" uk-icon="trash" onclick="deleteSetupList()"></button>
    </div>
</div>

<table class="uk-table uk-table-small uk-table-divider">
<thead>
    <tr>
        <th>REF</th>
        <th>TYPE</th>           
        <th>VALUE</th>   
        <th></th>
        <th></th>
    </tr>
</thead>

<tbody>

    @foreach ($data['setupList'][Session::get('type')] as $key => $setupList)
   
        <tr>
            <td>{{$key}}</td>
           @if (Session::get('type') == 'discount' || Session::get('type') == 'voucher')
                <td>{{$setupList['discount_type']}}</td>
                <td>{{$setupList['discount_value']}}</td>
           @else
                <td>{{$setupList['type']}}</td>
                <td>{{$setupList['value']}}</td>
           @endif
            <td><button class="uk-button uk-button-default uk-border-rounded" type="button" uk-icon="trash" onclick="deleteSetupList({{$key}})"></button></td>
        </tr>

    @endforeach
  
</tbody>
</table>




