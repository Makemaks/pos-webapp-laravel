
@inject('stringHelper', 'App\Helpers\StringHelper')

<div>
    <div href="{{route('store.show', $store->store_id)}}">
        <div class="uk-card uk-card uk-card-default uk-card-small uk-card-body">
            <div>
                <ul class="uk-iconnav uk-padding-small">
                    <li><a href="{{route('store.edit', $store->store_id)}}" class="" uk-icon="icon: pencil"></a></li>
                    <li><a class="" uk-icon="icon: sign-in" href="{{route('authentication.admin-store', $store->store_id)}}"></a></li>
                    <li><a class="" href="{{route('store-manager.dashboard', $store->store_id)}}"></a></li>
                </ul>
            </div>
            <div class="">
                @if ($store->store_image)
                    <img src="{{$store->store_image}}" alt="">
                @else
                    <div class="uk-section" style="background-color: #{{$stringHelper->getColor()}}"></div>
                @endif 
            </div>
            <div class="uk-card-body">
                <div class="uk-position-center uk-text-center uk-light"> 
                    <h3>{{$store->store_name}}</h3>
                    <p>{{$store->store_business_hours}}</p>
                </div>
            </div>
            <div>
                <div class="uk-margin">
                    
                    </div>
            </div>
        </div>
    </div>
</div>
       
   

