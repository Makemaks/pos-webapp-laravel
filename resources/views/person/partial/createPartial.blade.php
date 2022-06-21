@php
    use App\Models\Person;
    $action = '';
    $userHidden = '';
@endphp




<div>

    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text" for="line-1">Firstname<span class="uk-text-danger">*</span></label>
        @php
            $person_firstname = "";
            if ($action != 'Register'){
                $person_firstname = $data['personModel']->person_name['person_firstname'];
            }
        @endphp
        <div class="uk-form-controls">
            <input type="text" class="uk-input" id="form-stacked-text" name="person_name[person_firstname]" value="{{ old('person_name[person_firstname]' , $person_firstname) }}"></input>
        </div>
        
        @error('person_name[person_firstname]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin">
        
        <label class="uk-form-label" for="form-stacked-text">Firstname<span class="uk-text-danger">*</span></label>
        @php
            $person_lastname = "";
            if ($action != 'Register'){
                $person_lastname = $data['personModel']->person_name['person_lastname'];
            }
        @endphp
        <div class="uk-form-controls">
            <input type="text" class="uk-input" id="form-stacked-text" name="person_name[person_lastname]" value="{{ old('person_name[person_lastname]' , $person_lastname) }}"></input>
        </div>
        
        @error('person_name[person_lastname]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>


    <div class="uk-margin" {{$userHidden}}>
        <label class="uk-form-label" for="form-stacked-text">Preferred Name <span class="uk-text-danger"></span></label>
        @php
           
            $person_preferred_name = "";
            if ($action != 'Register' && $action != 'Edit'){
                $person_preferred_name = $data['personModel']->person_name['person_preferred_name'];
            }
        @endphp

        <input type="text" class="uk-input" name="person_preferred_name[]" id="person_preferred_name" value="{{ old('person_preferred_name[]' , $person_preferred_name) }}"></input>
            
        @error('person_name[person_preferred_name]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin">
        <label class="uk-form-label" for="form-stacked-text">Status<span class="uk-text-danger">*</span></label>
        <div class="uk-form-controls">
            <textarea class="uk-textarea" name="person_status[]" rows="3" placeholder="Textarea">{{ old('person_status[]' , $data['personModel']->person_status) }}</textarea>
        </div>
        @error('person_status[]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    </div>

    <div class="uk-margin" {{$userHidden}}>
        <label class="uk-form-label" for="form-stacked-text">Date of birth</label>
        
        <div class="uk-form-controls">
            <input placeholder="YYYY-MM-DD" type="text" class="uk-input" name="person_dob[]" id="person_dob" value="{{ old('person_dob[]' , $data['personModel']->person_dob) }}"></input>
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
                    <option value="{{$typeItem}}"{{ old('person_type[]', $data['personModel']->person_type) == $typeItem ? ' selected="selected"' : '' }}>{{Str::ucfirst($typeValue)}}</option>                           
                @endforeach
            </select>
        </div>
        
        @error('person_type[]')
            <div class="uk-text-danger">{{ $message }}</div>
        @enderror
    
    </div>
   
</div>