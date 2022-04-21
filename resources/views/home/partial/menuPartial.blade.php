<nav class="uk-navbar-container uk-margin" uk-navbar>
    <div class="uk-navbar-left">

        <ul class="uk-navbar-nav">
            <li>
                <a href="#">
                    <span class="uk-icon uk-margin-small-right" uk-icon="icon: star"></span>
                </a>
            </li>
        </ul>
        <div class="uk-navbar-nav">
            @php
                    $url = explode("/",Request::url());
            @endphp
            @if (array_key_exists('5', $url))
                {{ $data['categoryList'][$url[5] - 1] }}
            @endif
        </div>
    </div>
    <div class="uk-navbar-right">
        <div class="uk-navbar-item">
            <form action="javascript:void(0)">
                <input class="uk-input uk-form-width-large" type="text" placeholder="Input" autofocus id="barcodeinputID" onchange="GetInput(this)">
                <button class="uk-button uk-button-default" uk-icon="icon: search"></button>
            </form>
        </div>

        
    </div>
</nav>