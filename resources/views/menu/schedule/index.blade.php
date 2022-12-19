@extends('layout.master')
@php
    use App\Models\Setting;
@endphp

@section('content')

<button class="uk-button uk-button-default uk-border-rounded uk-button-danger" type="submit" form="settingUpdate" value="settingUpdate">
    Save
</button>

<div class="uk-margin">
   

    <ul class="uk-subnav uk-subnav-pill" uk-switcher id="0">
        <li><a href="#">Schedule</a></li>
        <li><a href="#" uk-icon="plus"></a></li>
    </ul>
    
    <ul class="uk-switcher uk-margin">
        <li>
            {{-- list of schedule in system --}}
        </li>
        <li>
            <ul class="uk-subnav uk-subnav-pill" uk-switcher id="1">
                <li><a href="#">Task</a></li>
                <li><a href="#">Create</a></li>
                <li><a href="#">Update</a></li>
                <li><a href="#">Delete</a></li>
            </ul>
            
            <ul class="uk-switcher uk-margin">
                <li>
                    <form action="">
            
                    </form>
                </li>
                <li>
                    <form action="">
                        
                    </form>
                </li>
                <li>
                    <form action="">
                        
                    </form>
                </li>
            </ul>
        </li>
    </ul>
    
</div>




@endsection