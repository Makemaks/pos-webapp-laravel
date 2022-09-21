@php
    use App\Models\Person;


    $action = '';
    $userHidden = '';
    $person_firstname = "";
    $person_lastname = "";
    $person_preferred_name = "";
    $address_email = [];

    $person_firstname = "";
    if ($action != 'Register' && $action != 'Edit'){
       if ( $data['personModel']) {
            $person_firstname = $data['personModel']->person_name['person_firstname'];
            $person_lastname = $data['personModel']->person_name['person_lastname'];
            $person_preferred_name = $data['personModel']->person_name['person_preferred_name'];
            $address_email = $data['personModel']->address_email;
       }
    }

@endphp


<div>

    <legend class="uk-legend">{{$person_firstname}} {{$person_lastname}}</legend>

    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text" for="line-1">Credit<span class="uk-text-danger">*</span></label>
       
        <div class="uk-form-controls">
            @if ($data['personModel'])
                <input type="text" class="uk-input" id="form-stacked-text" name="person_credit" value="{{ old('person_credit', $data['personModel']->person_credit) }}"></input>
            @else
                <input type="text" class="uk-input" id="form-stacked-text" name="person_credit" value="{{ old('person_credit') }}"></input>
            @endif
        </div>
        
        @error('person_credit')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text" for="line-1">Firstname<span class="uk-text-danger">*</span></label>
       
        <div class="uk-form-controls">
            <input type="text" class="uk-input" id="form-stacked-text" name="person_name[person_firstname]" value="{{ old('person_name[person_firstname]' , $person_firstname) }}"></input>
        </div>
        
        @error('person_name[person_firstname]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text">Firstname<span class="uk-text-danger">*</span></label>
      
        <div class="uk-form-controls">
            <input type="text" class="uk-input" id="form-stacked-text" name="person_name[person_lastname]" value="{{ old('person_name[person_lastname]' , $person_lastname) }}"></input>
        </div>
        
        @error('person_name[person_lastname]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div class="uk-margin" {{$userHidden}}>
        <label class="uk-form-label" for="form-stacked-text">Preferred Name <span class="uk-text-danger"></span></label>
     

        <div class="uk-form-controls">
            <input type="text" class="uk-input" name="person_preferred_name[]" id="person_preferred_name" value="{{ old('person_preferred_name[]' , $person_preferred_name) }}"></input>
        </div>
        
            
        @error('person_name[person_preferred_name]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">Status<span class="uk-text-danger">*</span></label>
        <div class="uk-form-controls">
            @if ($data['personModel'])
                <textarea class="uk-textarea" name="person_status[]" rows="3" placeholder="Textarea">{{ old('person_status[]' , $data['personModel']->person_status) }}</textarea>
            @else
                <textarea class="uk-textarea" name="person_status[]" rows="3" placeholder="Textarea">{{ old('person_status[]') }}</textarea>
            @endif
        </div>
        @error('person_status[]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin" {{$userHidden}}>
        <label class="uk-form-label" for="form-stacked-text">Date of birth</label>
        
        <div class="uk-form-controls">
            @if ($data['personModel'])
                <input placeholder="YYYY-MM-DD" type="text" class="uk-input" name="person_dob[]" id="person_dob" value="{{ old('person_dob[]' , $data['personModel']->person_dob) }}"></input>
            @else
                <input placeholder="YYYY-MM-DD" type="text" class="uk-input" name="person_dob[]" id="person_dob" value="{{ old('person_dob[]') }}"></input>
            @endif
        </div>
        @error('person_dob[]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div {{$userHidden}}>
        {{-- <div>
            <div>
                <label for="person-group">Group</label>
            </div>
            
            <div>
                <select modifier="" name="person_group[]" select-id="person-group" class="uk-select">
                    @foreach (Person::PersonGroup() as $groupItem => $groupValue)
                        <option value="{{$groupItem}}"{{ old('person_group[]', $data['personModel']->person_group_type) == $groupItem ? ' selected="selected"' : '' }}>{{Str::ucfirst($groupValue)}}</option>                           
                    @endforeach
                </select>
            
                @error('person_group[]')
                    <div class="uk-text-danger">{{ $message }}</div>
                @enderror
            </div>
        
            <div class="w3-border-bottom uk-select"></div>
        
        </div> --}}
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">Type</label>
        
        <div class="uk-form-controls">
            <select name="person_type[]" class="uk-select">
                @foreach (Person::PersonType() as $typeItem => $typeValue)
                    @if ($data['personModel'])
                        <option value="{{$typeItem}}"{{ old('person_type[]', $data['personModel']->person_type) == $typeItem ? ' selected="selected"' : '' }}>{{Str::ucfirst($typeValue)}}</option>                           
                    @else
                        <option value="{{$typeItem}}"{{ old('person_type[]') == $typeItem ? ' selected="selected"' : '' }}>{{Str::ucfirst($typeValue)}}</option>                           
                    @endif
                @endforeach
            </select>
        </div>
        
        @error('person_type[]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">Email</label>
        
        <div class="uk-form-controls">
            <input type="text" class="uk-input" name="person_dob[]" id="person_dob" value="{{ old('address_email[]') }}"></input>
        </div>

        @error('person_dob[]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <table class="uk-table uk-table-small uk-table-divider">
        <tbody>
         
            @if ($address_email)
                @foreach ($address_email as $email)
                    <tr>
                        <td>{{$email}}</td>
                    </tr>
                @endforeach
            @endif
    
        </tbody>
    </table>
   
</div>

