<div class="uk-button-group">
    <div class="uk-inline">
        <button class="uk-button uk-button-default" type="button"><span uk-icon="icon:  triangle-down"></span></button>
        <div uk-dropdown="mode: click; boundary: ! .uk-button-group; boundary-align: true;">
            <ul class="uk-nav uk-dropdown-nav">
                @foreach ($arrayList as $list)
                    <li><a href="#">list</a></li>
                @endforeach
            </ul>
        </div>
    </div>
</div>