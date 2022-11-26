@php
    $contact = json_decode($data['companyModel']->company_contact);
    $opening_hour = json_decode($data['companyModel']->company_opening_hour);
@endphp

<fieldset class="uk-fieldset">
    <div class="uk-grid">
        <div class="uk-grid-match uk-width-expand@m">
            <label for="name">Company Name</label>
            <input class="uk-input" type="text" placeholder="Name" name="company_name" value="{{$data['companyModel']->company_name}}">
        </div>

        <div class="uk-grid-match uk-width-expand@m">
            <label for="type">Company Type</label>
            <select class="uk-select" name="company_type">
                <option value="" selected disabled>Select Company Type</option>
                @foreach ($data['companyType'] as $key => $type)
                    <option value="{{$key}}" {{$key ==  $data['companyModel']->company_type ? 'selected' : ''}}>{{$type}}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="uk-grid">
        <div class="uk-grid-match uk-width-expand@m">
            <label for="stoer">Company Store</label>
            <select class="uk-select" name="company_store_id">
                <option value="" selected disabled>Select Store</option>
                @foreach ($data['storeList'] as $key => $store)
                    <option value="{{$store->store_id}}" {{$store->store_id ==  $data['companyModel']->company_store_id ? 'selected' : ''}}>{{$store->store_name}}</option>
                @endforeach
            </select>
        </div>

        <div class="uk-grid-match uk-width-expand@m">
            <label for="company">Parent Company</label>
            <select class="uk-select" name="parent_company_id">
                <option value="" selected disabled>Select Parent Company</option>
                @foreach ($data['companyList'] as $key => $company)
                    <option value="{{$company->company_id}}" {{$company->company_id ==  $data['companyModel']->parent_company_id ? 'selected' : ''}}>{{$company->company_name}}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="uk-margin-top">
        <ul class="uk-subnav uk-subnav-pill" uk-switcher>
            <li><a href="#">Contact</a></li>
            <li><a href="#">Opening Hours</a></li>
        </ul>
        
        <ul class="uk-switcher uk-margin">
            <li>
                <input class="uk-input uk-margin-bottom" type="text" placeholder="Company Contact" name="company_contact[]" value="{{$contact ? $contact[0] : ''}}">
                <input class="uk-input uk-margin-bottom" type="text" placeholder="Company Contact" name="company_contact[]" value="{{$contact ? $contact[1] : ''}}">
                <input class="uk-input" type="text" placeholder="Company Contact" name="company_contact[]" value="{{$contact ? $contact[2] : ''}}">
            </li>
            <li>
                <input class="uk-input uk-margin-bottom" type="text" placeholder="Company Opening Hour" name="company_opening_hour[]" value="{{$opening_hour ? $opening_hour[0] : ''}}">
                <input class="uk-input uk-margin-bottom" type="text" placeholder="Company Opening Hour" name="company_opening_hour[]" value="{{$opening_hour ? $opening_hour[1] : ''}}">
                <input class="uk-input" type="text" placeholder="Company Opening Hour" name="company_opening_hour[]" value="{{$opening_hour ? $opening_hour[2] : ''}}">
            </li>
        </ul>
    </div>
</fieldset>
