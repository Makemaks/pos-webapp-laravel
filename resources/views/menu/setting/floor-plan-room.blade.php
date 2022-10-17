@extends('layout.master')

@php

@endphp

@section('content')
<button class="uk-button uk-button-default uk-border-rounded uk-button-primary top-save-btn">Save</button>
<ul class="uk-subnav uk-subnav-pill" uk-switcher>
    <li>
        <a href="#">
            Rooms
        </a>
    </li>
    <li><a href="#" uk-icon="plus"></a></li>
</ul>
<ul class="uk-switcher uk-margin">
    <li>
        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th>Status</th>
                    <th>Capacity</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Size (Height)</th>
                    <th>Size (Width)</th>
                    
                </tr>
            </thead>
            <tbody>
                @php
                 $setting = json_decode($settingData->setting_building);
                @endphp
                  <form action="{{route('setting.store')}}" method="post">
                    @csrf
                        @foreach($setting->room as $key => $roomData)
                            <tr>
                                <input type="hidden" type="text" name="setting[{{$key}}][setting_id]"
                                    value="{{$key}}">
                                <td><input class="uk-input" type="number" name="setting[{{$key}}][status]"
                                    value="{{$roomData->status ?? ''}}"></td>
                                <td><input class="uk-input" type="number" name="setting[{{$key}}][capacity]"
                                    value="{{$roomData->capacity ?? ''}}"></td>
                                <td><input class="uk-input" type="text" name="setting[{{$key}}][name]"
                                    value="{{$roomData->name ?? ''}}"></td>
                                <td><input class="uk-input" type="text" name="setting[{{$key}}][description]"
                                    value="{{$roomData->description ?? ''}}"></td>
                                <td><input class="uk-input" type="text" name="setting[{{$key}}][height]"
                                    value="{{$roomData->size->height ?? ''}}"></td>
                                <td><input class="uk-input" type="text" name="setting[{{$key}}][width]"
                                    value="{{$roomData->size->width ?? ''}}"></td>
                            </tr>
                        @endforeach
                        <button type="submit" name="form_type" class="save-btn" style="display: none" value="room_data">
                  </form>
            </tbody>
        </table>
    </li>
    <li>
        <form action="{{route('setting.store')}}" method="post">
            @csrf
            <input type="hidden" name="setting_id" value="{{$settingId}}">
            <input type="hidden" name="form_type" value="room_data">
            <div class="uk-container uk-container-xsmall">
                <fieldset class="uk-fieldset">
                    <legend class="uk-legend"></legend>
                    <div class="uk-margin">
                        <label for="">Status</label>
                        <select class="uk-select" name="room_status">
                            <option value="1">1</option>
                            <option value="0">0</option>
                        </select>
                    </div>
                    <div class="uk-margin">
                        <label for="">Capacity</label>
                        <input class="uk-input" type="number" min="0" name="room_capacity">
                    </div>
                    <div class="uk-margin">
                        <label for="">Name</label>
                        <input class="uk-input" type="text" name="room_name">
                    </div>
                    <div class="uk-margin">
                        <label for="">Description</label>
                        <textarea class="uk-textarea" rows="5" placeholder="Textarea"
                            name="room_description"></textarea>
                    </div>
                    <div class="uk-margin">
                        <label for="">Height</label>
                        <input class="uk-input" min="0" type="number" name="room_height">
                    </div>
                    <div class="uk-margin">
                        <label for="">Width</label>
                        <input class="uk-input" min="0" type="number" name="room_width">
                    </div>
                    <div class="uk-margin">
                        <label for="">Note</label>
                        <input class="uk-input" type="text" name="room_note">
                    </div>
                    <div class="uk-first-column">
                        <button class="uk-button uk-button-default uk-border-rounded uk-width-1-1 uk-button-danger" type="submit">
                            SAVE
                        </button>
                    </div>
                </fieldset>
            </div>
            
        </form>
    </li>
</ul>
<script>
    $(document).on('click', '.top-save-btn', function () {
        $('.save-btn').click();
    });

</script>
@endsection
