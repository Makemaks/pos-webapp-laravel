@php
     use App\Helpers\StringHelper;
@endphp
<div class="uk-child-width-expand@s uk-text-center uk-grid-small uk-grid-match uk-button" uk-grid>
   
    <div>
        <div class="uk-light uk-border-rounded"style="background-color: #{{StringHelper::getColor()}}" onclick="update(this)">
           <div class="uk-padding">
                <p>Discount</p>
                <p class="uk-margin" uk-icon="icon: list; ratio: 3.5"></p>
           </div>
        </div>
    </div>
    <div>
        <div class="uk-light uk-border-rounded "style="background-color: #{{StringHelper::getColor()}}" onclick="update(this)">
           <div class="uk-padding">
                <p>Delivery</p>
                <p class="uk-margin" uk-icon="icon: user; ratio: 2.5"></p>
           </div>
        </div>
    </div>
    <div>
        <div class="uk-light uk-border-rounded "style="background-color: #{{StringHelper::getColor()}}" onclick="update(this)">
           <div class="uk-padding">
                <p>Refund</p>
                <p class="uk-margin" uk-icon="icon: user; ratio: 2.5"></p>
           </div>
        </div>
    </div>
    <div>
        <div class="uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}" onclick="update(this)">
           <div class="uk-padding">
                <p>Float</p>
                <p class="uk-margin" uk-icon="icon: grid; ratio: 3.5"></p>
           </div>
        </div>
    </div>
</div>
