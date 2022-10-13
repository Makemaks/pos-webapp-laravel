@extends('layout.master')

@php

@endphp

@section('content')
<table class="uk-table uk-table-small uk-table-divider">
    <thead>
        <tr>
            <th>Address</th>
            <th>Status</th>
            <th>Capacity</th>
            <th>Name</th>
            <th>Description</th>
            <th>Note</th>
            <th>Room</th>
            {{-- <th></th> --}}
        </tr>
    </thead>
    <tbody>
      
       @foreach($data['settingModel'] as $settingData)
       @php
        $decodeBuildingData = json_decode($settingData['setting_building']);
       @endphp
       <tr>
           <td>{{$decodeBuildingData->address_id}}</td>
           <td>{{$decodeBuildingData->status}}</td>
           <td>{{$decodeBuildingData->capacity}}</td>
           <td>{{$decodeBuildingData->name}}</td>
           <td>{{$decodeBuildingData->description}}</td>
           <td>{{$decodeBuildingData->note[0]}}</td>
           <td><input class="uk-input" step="0.01" type="number" name="reservation_deposit"></td></td>
           {{-- <td><input class="uk-input" step="0.01" type="number" name="reservation_deposit"></td> --}}
       </tr>
       @endforeach
    </tbody>
</table>
@endsection
