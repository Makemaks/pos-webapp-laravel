@extends('layout.master')
@inject('settingModel', 'App\Models\Setting')

@php
use App\Models\Setting;
use App\Models\Project;
@endphp

@section('content')
{{-- @include('contact.partial.menuPartial') --}}
<table class="uk-table uk-table-divider uk-table-small uk-table-responsive">
    <thead>
        <tr>
            <th></th>
            <th>Type</th>
            <th>VAT</th>
            <th>Project Type</th>
            <th>Project Stage</th>
            <th>Product Category</th>
            <th></th>
            <th></th>

        </tr>
    </thead>
    <tbody>
       
        @foreach ($data['settingList'] as $setting)
            @php
                //$addressDetails = $addressModel->Details($person);
            @endphp
            <tr>
                <td>
                  
                </td>
                <td>
                   {{--  {{ Setting::Type()[$setting->setting_type]}}
 --}}
                </td>
                <td>{{-- {{$setting->setting_vat}} --}}</td>
                <td>

                    {{ $setting->setting_project_type}}

                </td>
                <td>

                    {{ $setting->setting_project_stage }}

                </td>
                <td>
                   {{ $setting->setting_product_category }}

                </td>

                <td>
                    <a href="{{route('setting.edit', $setting->setting_id)}}" class="uk-button uk-button-default">
                        <span class="orange fa fa-pencil-alt"></span>
                    </a>
                </td>
                <td>
                    @php
                    $route = 'setting';

                    @endphp
                    <button type="button" class="uk-button uk-button-default uk-width-expand" uk-toggle="target: #delete-modal-{{$setting->setting_id}}">
                        <span class="uk-text-danger fa fa-trash-alt"></span>
                    </button>
                    {{-- @include('partial.deleteModal', ['id' => $setting->setting_id]) --}}

                </td>
            </tr>
        @endforeach

    </tbody>
</table>


{{-- @include('partial.pagination', ['paginator' => $data['settingList']]) --}}

@endsection
