@php
     $action =  Str::after(Request::route()->getName(), '.'); 
     $active = '';
    $actionList = [
        'store',
        'reserve',
    ];
    
    if ($action == 'create') {
        $action = 'store';
    }
@endphp

<ul class="uk-subnav uk-subnav-pill" uk-margin>
    @foreach ($actionList as $actionItem)
        @php
            $href = 'contact-manager.'.$actionItem;
        @endphp
        <li class="@if($actionItem == $action){{'uk-active'}} @endif"><a href="">{{$actionItem}}</a></li>
        
    @endforeach
</ul>