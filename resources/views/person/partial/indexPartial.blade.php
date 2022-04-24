@inject ('personModel', 'App\Models\Person')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')


    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Role</th>
                <th>Position</th>
                <th>Email</th>
                <th>Tel</th>
                <th><th><a href="{{route('person.create')}}" class="uk-button uk-text-primary" uk-icon="plus"></a></th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['personList'] as $person) 
          
                <tr>
                    <td>
                        {{$person->person_firstname}} {{$person->person_lastname}}
                        @if ($person->company_id)
                            <p class="uk-text-meta uk-margin-remove-top">
                                <a href="{{route('company.show', $person->company_id)}}">{{$person->company_name}}</a>
                                <a uk-icon="icon: pencil" href="{{route('person.edit', $person->person_id)}}"></a>
                            </p>
                        @endif
                    </td>
                    <td>{{$person->person_role}}</td>
                    <td>{{$person->person_role}}</td>
                    <td>{{$person->person_email_1}}</td>
                    <td>{{$person->person_phone_1}}</td>
                   
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
   

@include('partial.paginationPartial', ['paginator' => $data['personList']])