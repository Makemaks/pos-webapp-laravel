@php
    use App\Models\Company;
    use App\Models\Stock;

    $companyList = new Stock();
@endphp
<table class="uk-table uk-table-responsive uk-table-divider">
    <thead>
        <tr>
                <th></th>
                <th>REF</th>
                @isset($data['companyList'])
                    @foreach ($data['companyList']->toArray()[0] as $keystock => $item)
                        @if ($keystock != 'company_id' && $keystock != 'created_at' &&	$keystock != 'updated_at')
                            <th>{{Str::after($keystock, 'company_')}}</th>
                        @endif
                    @endforeach
                @endisset
            <th></th>
        </tr>
    </thead>
    <tbody>
       
        @isset($data['companyList'])
                @foreach ($data['companyList']->toArray() as $keyStockSupplier => $companyList)
                <tr>
                    <td>
                        <div class="uk-margin">
                            <div class="uk-form-controls">
                                <input class="uk-checkbox" type="checkbox"
                                    value="{{ $companyList['company_id'] }}"
                                    name="company_checkbox[]">
                            </div>
                        </div>
                    </td>
                    @foreach ($companyList as $keystock => $stock)
                            @if ($keystock == 'company_id')
                                <input class="uk-input" type="text" name="company[{{$keyStockSupplier}}][{{$keystock}}]" value="{{$stock}}" hidden>
                            <td>
                                    <button class="uk-button uk-button-default uk-border-rounded" onclick="">{{$stock}}</button>
                            </td>
                        
                            @elseif ($keystock == 'company_name')
                                <td>
                                    <input class="uk-input" type="text" name="company[{{$keyStockSupplier}}][{{$keystock}}]" value="{{$stock}}">
                                </td>
                            @elseif($keystock == 'company_contact' || $keystock == 'parent_company_id')
                                <td>
                                    <input class="uk-input" type="number" name="company[{{$keyStockSupplier}}][{{$keystock}}]" value="{{$stock}}">
                                </td>
                            @elseif($keystock == 'company_opening_hour')
                                <td>
                                    <input type="datetime-local" name="company[{{$keyStockSupplier}}][start_from]" class="uk-input" placeholder="Start Date" value="{{ isset(json_decode($stock)->start_from) ? json_decode($stock)->start_from : '' }}">
                                </td>
                                <td>
                                    <input type="datetime-local" name="company[{{$keyStockSupplier}}][end_to]" class="uk-input" placeholder="End Date" value="{{ isset(json_decode($stock)->end_to) ? json_decode($stock)->end_to : '' }}" >
                                </td>
                            @elseif($keystock == 'company_type')
                                <td>
                                    <select class="uk-select" id="form-stacked-select" name="company[{{$keyStockSupplier}}][{{$keystock}}]">
                                        <option value="" selected disabled>SELECT ...</option>
                                        
                                            @foreach (Company::CompanyType() as $key => $type)
                                            <option @if($key == $stock) selected @endif value="{{$key}}" class="uk-input">
                                                {{Str::upper($type)}}
                                            </option>
                                        @endforeach
                                    
                                    </select>
                                </td>
                            @elseif($keystock == 'company_store_id')
                                <td>
                                    <a href="{{route('company.edit', $stock)}}" class="uk-button uk-button-default uk-border-rounded">{{$stock}}</a>
                                </td>
                            @endif
                        @endforeach
                </tr>    
            @endforeach
        @endisset
      
    </tbody>
</table>