@php
    use App\Models\Person;
    $action =  Str::after(Request::route()->getName(), '.');
    $person_firstname = "";
    $person_lastname = "";

    if ($data['userModel']->person_name) {
        $person_firstname = json_decode($data['userModel']->person_name, true)['person_firstname'];
        $person_lastname = json_decode($data['userModel']->person_name, true)['person_lastname'];
    }

 
@endphp


<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Firstname" value="{{ old('person_firstname', $person_firstname) }}">
</div>
@error('person_firstname')
        <div class="uk-text-danger">{{ $message }}</div>
@enderror

<div class="uk-margin">
    <input class="uk-input" type="text" placeholder="Lastname" value="{{ old('person_lastname',  $person_lastname) }}">
</div>
@error('person_lastname')
        <div class="uk-text-danger">{{ $message }}</div>
@enderror


<div class="uk-margin">
    <select class="uk-select">
        @foreach (Person::PersonType() as $key => $type)
          <option>{{$type}}</option>
        @endforeach
    </select>
</div>
