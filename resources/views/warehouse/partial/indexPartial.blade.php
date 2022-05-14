
@php
    use App\Models\warehouse;
    //use App\Models\Scheme;
  
@endphp

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            
            <th></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>

        @foreach ($data['warehouseList'] as $warehouse)
       
            <tr>
               {{--  <td><a href="{{route('warehouse.edit', $warehouse->warehouse_id)}}" class="uk-button uk-button-danger uk-border-rounded">{{$warehouse->warehouse_id}}</a></td>
                <td>{{ json_decode($warehouse->person_name, true)['person_firstname'] }} {{ json_decode($warehouse->person_name, true)['person_lastname'] }}</td>
                <td>{{ $warehouse->email }}</td>
                <td>{{ warehouse::warehouseType()[$warehouse->warehouse_type] }}</td>
                <td>
                    @if ($warehouse->warehouse_is_disabled == 1)
                        <span class="uk-text-danger" uk-icon="check"></span>
                </td> 
                <td>                            
                    {{$warehouse->created_at}}
                </td> 
                <td>
                    @if ( Warehouse::warehouseType()[$warehouse->warehouse_type] == 'Customer')
                            <a class="uk-button uk-button-danger uk-border-rounded" uk-icon="heart" href="{{route('init.dashboard', ['warehouse', $warehouse->warehouse_id])}}" uk-icon="icon: warehouse"></a>
                    @endif
                </td>     --}}
                <td><a class="uk-button uk-button-danger uk-border-rounded" href="" uk-icon="history" title="History"></a></td>
                <td><a class="uk-button uk-button-danger uk-border-rounded" href="" uk-icon="sign-in" title="Login"></a></td>
            </tr>

        @endforeach
      
    </tbody>
</table>




