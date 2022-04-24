
@inject ('companyModel', 'App\Models\company')
<form>
    <fieldset class="uk-fieldset">

        <legend class="uk-legend">{{$data['companyModel']->company_name}}</legend>

        <div class="uk-margin">
            <input class="uk-input" type="text" placeholder="Name" value="{{$data['companyModel']->company_name}}">
        </div>

        <div class="uk-margin">
            <select class="uk-select">
                @foreach ($companyModel::CompanyType() as $key => $type)
                    <option value="{{$key}}">{{$type}}</option>
                @endforeach
            </select>
        </div>

        <div class="uk-margin">
            <textarea class="uk-textarea" rows="2" placeholder="Description">{{$data['companyModel']->company_description}}</textarea>
        </div>

    </fieldset>
</form>