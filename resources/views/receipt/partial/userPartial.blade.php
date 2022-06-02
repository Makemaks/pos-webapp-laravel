

@php
    
   /*  foreach ($data['userList'] as $key => $value) {
        $searchArray[] = [
            'value' => $value->user_id,
            'text' => $value->person_firstname . ' ' . $value->person_lastname
        ];
    } */

   
@endphp

<nav class="uk-navbar-container" uk-navbar>
    <div class="uk-navbar-left">
        <div class="uk-navbar-item">
            {{-- <div class="uk-grid-small" uk-grid>
                <div>
                    @include('partial.searchPartial', ['hidden_field_name' => 'receipt_user_id'])
                </div>
                <div>
                    <button type="button" class="uk-border-rounded uk-button uk-button-default" uk-icon="icon: search" onclick="SetFocus('barcode_search')"></button>
                </div>
                <div>
                    <a href="{{route('user.create')}}" class="uk-border-rounded uk-button uk-button-default" uk-icon="icon: plus"></a>
                </div>
            </div> --}}
        </div>
    </div>
    <div class="uk-navbar-right">
        <div  class="uk-navbar-item">
            <div class="uk-grid-small" uk-grid>
                <div class="uk-width-expand">
                <input name="order_change_value" class="uk-input" id="changeValueID" placeholder="Cash" type="text">
                </div>
                <div><button type="button" class="uk-button uk-button-default" onclick="CalculateChange()">Calculate</button></div>
            </div>
        </div>   
    </div>
</nav>


<div class="uk-margin-left uk-margin-right uk-align-center" uk-slider>

    <div class="uk-position-relative">

        <div class="uk-slider-container">
            <div class="uk-grid-match uk-grid-small uk-slider-items uk-child-width-1-2 uk-child-width-1-3@s uk-child-width-1-4@m">
                {{-- @include('user.partial.indexPartial')  --}}
            </div>
        </div>

        <div class="uk-hidden@s uk-light">
            <a class="uk-position-center-left uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
        </div>

        <div class="uk-visible@s">
            <a class="uk-position-center-left-out uk-position-small" href="#" uk-slidenav-previous uk-slider-item="previous"></a>
            <a class="uk-position-center-right-out uk-position-small" href="#" uk-slidenav-next uk-slider-item="next"></a>
        </div>

    </div>

    <ul class="uk-slider-nav uk-dotnav uk-flex-center uk-margin"></ul>

</div>