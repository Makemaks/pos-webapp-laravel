

@php
    
use App\Helpers\NumpadHelper;
use App\Helpers\StringHelper;
use App\Helpers\CurrencyHelper;
use App\Models\Person;
use App\Models\Company;
use App\Models\Stock;
use App\Models\User;

@endphp

@isset($data['personModel'])
<div uk-grid>
                           
    <div>
        <a class="uk-link-text" href="{{route('person.edit', $data['personModel']->person_id)}}"  title="{{$data['personModel']->person_id}}">
            {{$data['personModel']->person_name['person_firstname']}} {{$data['personModel']->person_name['person_lastname']}}
        </a>
    
        
        <p class="uk-text-meta uk-margin-remove-top">
            @if ($data['personModel']->persontable_type == 'Company')
                @php
                    $company = Company::find($data['personModel']->persontable_id);
                @endphp
                <a href="{{route('company.show', $company->company_id)}}">{{$company->company_name}}</a>
            @else
                @php
                    $user = User::Person('user_person_id', $data['personModel']->person_id)->first();
                @endphp
            
                @if ($user)
                    <a href="{{route('user.show', $user->user_id)}}">{{$user->email}}</a>
                @endif
    
            @endif
        </p>
    </div>

    {{-- dont show on person index --}}


   
</div>
@endisset
