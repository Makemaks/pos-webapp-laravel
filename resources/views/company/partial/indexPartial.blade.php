
@inject ('companyModel', 'App\Models\company')
@inject('dateTimeHelper', 'App\Helpers\DateTimeHelper')


    <table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
        <thead>
            <tr>
                <th>Name</th>
                <th>Main</th>
                <th>Customer</th>
                <th>Supplier</th>
                <th>Hours</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['companyList'] as $company) 
                <tr>
                    <td>
                        {{$company->company_name}}
                        <a uk-icon="icon: pencil" href="{{route('company.edit', $company->company_id)}}"></a>
                    </td>
                    <td>
                        @if ($company->company_type == 0)
                            <span uk-icon="icon: check"></span>
                        @endif
                    </td>
                    <td>
                        @if ($company->company_type == 0)
                            <span uk-icon="icon: check"></span>
                        @endif
                    </td>
                    <td>
                        @if ($company->company_type == 1)
                            <span uk-icon="icon: check"></span>
                        @endif
                    </td>
                    <td>{{$company->company_business_hours}}</td>
                    <td><a class="uk-button uk-button-default" uk-icon="icon: list" href="{{route('contact-manager.profile', $company->company_id)}}"></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
   

@include('partial.paginationPartial', ['paginator' => $data['companyList']])