@extends('layout.master')

@inject ('personModel', 'App\Models\Person')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')

@section('content')
<table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
    <thead>
        <tr>
            <th>Account</th>
            <th>Company</th>
            <th>Store</th>
            <th>Created</th>
            <th>Table Heading</th>
        </tr>
    </thead>
    <tbody>
        
        @foreach ($data['settingList'] as $setting)
            <tr>
                <td>
                    {{$setting->account_name}}
                    <a uk-icon="icon: pencil"  href="{{route('setting.edit', $setting->setting_id)}}"></a>
                </td>
                <td>
                    {{$setting->company_name}}
                </td>
                <td>
                    {{$setting->store_name}}
                </td>
                <td>{{$setting->created_at}}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection