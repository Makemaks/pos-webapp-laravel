
@php
    use App\Helpers\StringHelper;
@endphp

<div class="uk-child-width-1-4@s uk-text-center uk-grid-small uk-grid-match" uk-grid>
       
    <div>
        <button class="uk-light uk-border-rounded uk-button uk-link-reset" style="background-color: #{{StringHelper::getColor()}}" id="discountPercentageID" value="discount" onclick="showSetupList('discount')">
           <div class="uk-padding">
                <p>Discount</p>
                <p class="uk-margin" uk-icon="icon: tag; ratio: 2.5"></p>
           </div>
        </button>
    </div>
   
    <div>
        <button class="uk-light uk-border-rounded uk-button uk-link-reset" style="background-color: #{{StringHelper::getColor()}}" id="deliveryID" value="delivery" onclick="showSetupList('delivery')">
           <div class="uk-padding">
                <p>Delivery</p>
                <p class="uk-margin" uk-icon="icon: world; ratio: 2.5"></p>
           </div>
        </button>
    </div>
    <div>
        <button class="uk-light uk-border-rounded uk-button uk-link-reset" style="background-color: #{{StringHelper::getColor()}}" id="refundID" value="refund" onclick="showOrder()">
           <div class="uk-padding">
                <p>Refund</p>
                <p class="uk-margin" uk-icon="icon: list; ratio: 2.5"></p>
           </div>
        </button>
    </div>
    <div>
        <button class="uk-light uk-border-rounded uk-button uk-link-reset" style="background-color: #{{StringHelper::getColor()}}" id="floatID" value="float" onclick="showSetupList('floatID')">
           <div class="uk-padding">
                <p>Float</p>
                <p class="uk-margin" uk-icon="icon: grid; ratio: 3.5"></p>
           </div>
        </button>
    </div>
</div>