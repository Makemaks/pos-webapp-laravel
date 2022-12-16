@extends('layout.master')
@php
    use App\Models\Setting;
@endphp

@section('content')

<button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
    Save
</button>

<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li>
        <a href="#">
            {{Str::upper(Request::get('view'))}}
        </a>
    </li>
</ul>

<ul class="uk-margin">
    <div>
        <label class="uk-form-label" for="form-stacked-text">Column</label>
        <select class="uk-select" name="" id="">
            @foreach($data['columnList'] as $column)
                <option value="{{$column}}">{{$column}}</option>
            @endforeach
        </select>
        
    </div>

    <div>
        <label class="uk-form-label" for="form-stacked-text">Actions</label>
        <select class="uk-select" name="" id="">
            <option value="1">Task</option>
            <option value="2">Update</option>
            <option value="3">Delete</option>
        </select>
        
    </div>
</ul>

@endsection