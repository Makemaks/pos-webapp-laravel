@include('dashboard.partial.departmentTotalPartial')
@isset($route)
<form action="{{ route($route . '.index') }}" method="GET">
<input type="hidden" name="isdownload" value="true">
<input type="hidden" name="fileName" value="{{Request::get('fileName')}}">
<input type="hidden" name="format" value="pdf">

<button class="uk-button uk-button-default uk-border-rounded" type="submit">
    PDF
</button>
<button class="uk-button uk-button-default uk-border-rounded" type="submit">
    CSV
</button>
</form>
@endisset