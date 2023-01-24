

<div class="uk-grid-small uk-child-width-auto uk-margin" uk-grid>

    <div>
        @include('home.partial.menuPartial')
    </div>

    <div>
        <div class="uk-search uk-search-default">
            <span uk-search-icon></span>
            <input class="uk-search-input" type="search" {{-- onclick="showKeypad()"  --}}onchange="searchInput(this)" autocomplete="off">
        </div>
    </div>
   
</div>