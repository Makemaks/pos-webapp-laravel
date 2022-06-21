@php
$applicationList = [];
$route = Str::before(Request::route()->getName(), '.');
$action = Str::after(Request::route()->getName(), '.');

if ($action === 'index') {
    $action = 'create';
} elseif ($action === 'create') {
    $action = 'store';
} elseif ($action === 'edit') {
    $action = 'update';
}

$routeList = ['authentication', 'home', 'dashboard', 'receipt', 'order'];

@endphp



@if (array_search($route, $routeList) == NULL)
       
        @if ($action == 'index' || $action == 'create')
            <div class="uk-navbar-item">
                <a href="{{route($route.'.'.$action)}}" class="uk-border-rounded uk-button uk-button-default uk-text-danger" uk-icon="plus"></a>
            </div>
        @elseif($action == 'store')
            <div class="uk-navbar-item">
                <button type="submit" form="{{$route}}-store" class="uk-border-rounded uk-button uk-button-default uk-text-danger" uk-icon="upload"></button>
            </div>
        @elseif($action == 'update')
            <div class="uk-navbar-item">
                <button type="submit" form="{{$route}}-update" class="uk-border-rounded uk-button uk-button-default uk-text-danger" uk-icon="push"></button>
            </div>
            <div class="uk-navbar-item">
                <button uk-toggle="target: #modal-{{Request::route($route)}}" class="uk-border-rounded uk-button uk-button-default uk-text-danger" uk-icon="trash"></button>
            </div>
        @endif

       
@endif
