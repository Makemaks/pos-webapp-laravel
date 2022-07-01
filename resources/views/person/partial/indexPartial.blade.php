@php
    use App\Models\Person;
    use App\Models\Company;
    use App\Models\User;
    use App\Models\Receipt;

    $route = Str::before(Request::route()->getName(), '.');
@endphp

{{-- <div class="uk-grid-small" uk-grid>
    <div class="uk-width-expand">
        <input type="text" class="uk-input uk-form-width-expand" value="{{Session::get('searchSearch')}}" onchange="searchCustomer(this)">
    </div>
    <div class="uk-width-auto">
        <button uk-icon="plus" class="uk-button uk-button-default uk-border-rounded" onclick="createCustomer()"></button>
    </div>
</div> --}}

<div class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">

    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                @if ($route != 'home-api')
                    <th>DOB</th>
                    <th>Type</th>
                    <th>Role</th>
                @endif
                <th>Email/Tel</th>
                <th><span uk-icon="plus"></span></th>
                <th><span uk-icon="plus"></span></th>
                <th>Group</th>
                <th>Discount</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['personList'] as $person) 
                
                @if ($person->person_id)
                    <tr>
                        <td>
                            @php
                                $data['personModel'] = $person;
                            @endphp
                            @include('person.partial.personPartial', ['data' => $data, 'view' => null])
                        </td>
                       
                        @if ($route != 'home-api')
                            <td>{{$person->person_dob}}</td>
                            <td>{{Person::PersonType()[$person->person_type]}}</td>
                            <td>{{$person->person_role}}</td>
                        @endif
    
                        <td>
                            @foreach ($person->person_email as $person_email)
                                <div>{{$person_email}}</div>
                            @endforeach
                            @foreach ($person->person_phone as $person_phone)
                                <p class="uk-margin-remove-top">{{$person_phone}}</p>
                            @endforeach
                        </td>
                       
                        <td>
                            <button uk-icon="cart" class="uk-button uk-button-default uk-border-rounded" onclick="useCustomer({{$person->person_id}})"></button>
                        </td>
                        <td>
                            @php
                                $user = User::Person('user_person_id', $person->person_id)->first();
                            @endphp
                            
                            @if ($user == Null)
                                <a uk-icon="user" class="uk-button uk-button-default uk-border-rounded" href="{{route('user.create', ['person_id' => $person->person_id])}}">
                                    
                                </a>
                            @endif
                        </td>
                        <td>
                            @if ($person->person_stock_cost)
                                <div>Group {{$person->person_stock_cost[1]['column']}}</div>
                                <p class="uk-margin-remove-top">Price {{$person->person_stock_cost[1]['row']}}</p>
                            @endif
                        </td>
                        <td>
                            @if ($person->person_discount)
                               
                                <p class="uk-margin-remove-top">{{Receipt::ReceiptCostOverrideType()[$person->person_discount[1]['type']]}}{{$person->person_discount[1]['value']}}</p>
                              
                            @endif
                        </td>
                    </tr>
                @endif
                
    
            @endforeach
        </tbody>
    </table>
       
    
    @include('partial.paginationPartial', ['paginator' => $data['personList']])

</div>