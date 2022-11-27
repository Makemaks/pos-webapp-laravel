@inject ('addressModel', 'App\Models\address')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')


    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
            <tr>
                <th></th>
                <th>Address</th>
                <th>type</th>
                <th><a href="{{route('address.create')}}" class="uk-button uk-text-primary" uk-icon="plus"></a></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['addressList'] as $address) 
                <tr>
                    <td><input name="address_id" type="radio" class="uk-radio" value="{{$address->address_id}}"></td>
                    <td>
                        {{$address->address_line_1}} {{$address->address_line_2}}
                        <p class="uk-text-meta">{{$addressModel->CategoryType()[$address->address_category_type]}}</p>
                    </td>
                    
                    <td>
                        <span class="uk-text-meta">{{$addressModel->DeliveryType()[$address->address_delivery_type]}}</span>
                    </td>
                    <td><a class="uk-button uk-button-default" uk-icon="icon: pencil" href="{{route('address.edit', $address->address_id)}}"></a></td>
                   
                </tr>
            @endforeach
        </tbody>
    </table>
   

@include('partial.paginationPartial', ['paginator' => $data['addressList']])