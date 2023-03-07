@extends('layout.master')

@php

@endphp

@section('content')
<button class="uk-button uk-button-default uk-border-rounded uk-button-primary top-save-btn">Save</button>
<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>Address</th>
            <th>Status</th>
            <th>Capacity</th>
            <th>Name</th>
            <th>Description</th>
            <th>Note</th>
            <th>Room Count</th>
            <th>Room</th>
        </tr>
    </thead>
    <tbody>
        <form action="{{route('setting.store')}}" method="post">
            @csrf
        @foreach($data['settingModel'] as $key => $settingData)
        @php
        $decodeBuildingData = json_decode($settingData['setting_building']);
        @endphp
            <tr>
                <input type="hidden" type="text" name="setting[{{$key}}][setting_id]" value="{{$settingData['setting_id']}}">
                <td><input class="uk-input" type="number" name="setting[{{$key}}][building_address_id]"
                        value="{{$decodeBuildingData->address_id ?? ''}}"></td>
                <td><input class="uk-input" type="number" name="setting[{{$key}}][building_status]"
                        value="{{$decodeBuildingData->status}}"></td>
                <td><input class="uk-input" type="number" name="setting[{{$key}}][building_capacity]"
                        value="{{$decodeBuildingData->capacity}}"></td>
                <td><input class="uk-input" type="text" name="setting[{{$key}}][building_name]" value="{{$decodeBuildingData->name}}"></td>
                <td><input class="uk-input" type="text" name="setting[{{$key}}][building_description]"
                        value="{{$decodeBuildingData->description}}"></td>
                <td><input class="uk-input" type="text" name="setting[{{$key}}][building_note]" value="{{$decodeBuildingData->note[0]}}">
                </td> 
                <td>{{count($decodeBuildingData->room)}}</td>
                <td><a class="uk-button uk-button-primary uk-border-rounded" href="{{route('setting.index', ['setting_id'=>$settingData['setting_id'], 'form_type'=>'building_data'])}}">Add</a></td>
            </tr>
        @endforeach
        <button type="submit" name="form_type" class="save-btn" style="display: none" value="building_data">

    </form>

    </tbody>
</table>
@include('partial.paginationPartial', ['paginator' => $data['settingModel']])
<script>
    $(document).on('click','.top-save-btn', function() {
        $('.save-btn').click();
    });
</script>
@endsection
