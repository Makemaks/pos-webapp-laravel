<div class="uk-background-default uk-padding uk-box-shadow-small">
    <div>
        <div class="uk-child-width-1-2" uk-grid>
        <div>
            <p class="uk-text-lead uk-margin-remove-bottom">Personnel Stats</p>
            <p class="uk-text-meta uk-margin-remove-top">More than +{{$orderList->count()}}</p>
        </div>
        <div>            
            <a class="uk-align-right uk-button uk-button-default uk-border-rounded" href="{{route('user.create')}}">
                <span uk-icon="icon: plus"></span>
            </a>
            <a class="uk-align-right uk-button uk-button-default" href="">
                <span uk-icon="icon: list"></span>
            </a>
        </div>
    </div>
    <table class="uk-table uk-table-divider uk-table-small uk-text-small">
        <thead>
            <tr>
                <th>Name</th>
                <th>company</th>
                <th>Earnings</th>
                <th>Comission</th>
                <th>Rating</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['personelStats'] as $order)
                <tr>
                    <td class="uk-text-bold">                                    
                    {{$order->person_firstname}} {{$order->person_lastname}}
                    </td>
                    <td>{{$order->company_name}}</td>
                    <td>{{$order->service_price_total}}</td>
                    <td></td>
                    <td></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</div>
@include('partial.paginationPartial', ['paginator' => $orderList])