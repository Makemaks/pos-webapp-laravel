@php
    use App\Models\User;
    //use App\Models\Scheme;
  
@endphp

<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>REF</th>
            <th>Name</th>           
            <th>Email</th>   
            <th>Type</th>         
            <th>Disabled</th>
            <th>Last Login</th>
            <th></th>
            <th></th>
        </tr>
    </thead>
    
    <tbody>

        @foreach ($data['userList'] as $user)
       
            <tr>
                <td><a href="{{route('user.edit', $user->user_id)}}" class="uk-button uk-button-default uk-border-rounded">{{$user->user_id}}</a></td>
                <td>{{ json_decode($user->person_name, true)['person_firstname'] }} {{ json_decode($user->person_name, true)['person_lastname'] }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ User::UserType()[$user->user_type] }}</td>
                <td>
                    @if ($user->user_is_disabled == 1)
                        <span class="uk-text-danger" uk-icon="check"></span>
                    @endif                                     
                </td>     
                <td>                            
                    {{$user->user_last_login_at}}
                </td> 
                <td>
                    @if ( User::UserType()[$user->user_type] == 'Customer')
                            <a class="uk-button uk-button-default uk-border-rounded" uk-icon="heart" href="{{route('init.dashboard', ['user', $user->user_id])}}" uk-icon="icon: user"></a>
                    @endif
                </td>
                <td><a class="uk-button uk-button-default uk-border-rounded" href="" uk-icon="history" title="History"></a></td>
                <td><a class="uk-button uk-button-default uk-border-rounded" href="" uk-icon="sign-in" title="Login"></a></td>
            </tr>

        @endforeach
      
    </tbody>
</table>




