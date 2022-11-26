@php
    use App\Models\Company;
@endphp
<table class="uk-table uk-table-small uk-table-divider uk-table-responsive">
    <thead>
        <tr>
            <th>REF</th>
            <th>Company Name</th>
            <th>Company Type</th>
            <th>Company Store</th>
            <th>Parent Company</th>
            <th><a href="{{ route('company.create') }}" class="uk-button uk-text-primary" uk-icon="plus"></a></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data['companyList'] as $company)
            <tr>
                <td>{{ $company->company_id }}</td>
                <td>{{ $company->company_name }}</td>
                <td>
                    @foreach (Company::CompanyType() as $key => $type)
                        @if($company->company_type == $key)
                            {{$type}}
                            @break
                        @endif
                    @endforeach
                </td>
                <td>{{ $company->store_name }}</td>
                <td>{{ $company->parent_company }}</td>
                <td>
                    <a class="uk-button uk-button-default" uk-icon="icon: pencil"
                        href="{{ route('company.edit', $company->company_id) }}"></a>
                    <a uk-toggle="target: #modal-{{ $company->company_id }}" class="uk-button uk-button-default"
                        uk-icon="icon: trash"></a>
                </td>
            </tr>
            @include('partial.modalPartial', ['model_id' => $company->company_id])
        @endforeach
    </tbody>
</table>

@include('partial.paginationPartial', ['paginator' => $data['companyList']])
