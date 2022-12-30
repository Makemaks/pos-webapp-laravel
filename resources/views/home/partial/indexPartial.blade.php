{{-- @php
     use App\Helpers\StringHelper;
@endphp
<div class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">
   
    <div class="uk-child-width-1-2@s uk-text-center uk-grid-small uk-grid-match uk-button" uk-grid>

        <div>
            <div class="uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}" onclick="showStock()">
               <div class="uk-padding">
                    <p>Stock</p>
                    <p class="uk-margin" uk-icon="icon: database; ratio: 3.5"></p>
               </div>
            </div>
        </div>
        <div>
            <div class="uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}" onclick="showOrder()">
               <div class="uk-padding">
                    <p>Orders</p>
                    <p class="uk-margin" uk-icon="icon: list; ratio: 3.5"></p>
               </div>
            </div>
        </div>
        <div>
            <div class="uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}" onclick="showCustomer()">
               <div class="uk-padding">
                    <p>Customers</p>
                    <p class="uk-margin" uk-icon="icon: user; ratio: 2.5"></p>
               </div>
            </div>
        </div>
        <div>
            <div class="uk-light uk-border-rounded" style="background-color: #{{StringHelper::getColor()}}" onclick="showSetting()">
               <div class="uk-padding">
                    <p>Setting</p>
                    <p class="uk-margin" uk-icon="icon: cog; ratio: 2.5"></p>
               </div>
            </div>
        </div>
    </div>
    
    
</div>

 --}}