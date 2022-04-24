@php
    use App\Helpers\DateTimeHelper;
@endphp
<div class="uk-background-default uk-padding">
    <div class="uk-child-width-1-2" uk-grid>
        <div>
            <p class="uk-text-lead uk-margin-remove-bottom">Order Stats</p>
            <p class="uk-text-meta uk-margin-remove-top">More than +{{$data['orderList']->count()}}</p>
        </div>
        <div>
            <a class="uk-align-right uk-button uk-button-danger uk-border-rounded" href="{{route('order.create')}}">
                <span uk-icon="icon: plus"></span>
            </a>
        </div>
    </div>
    <table class="uk-table uk-table-divider uk-table-small uk-text-small">
        <thead>
            <tr>
                <th>Group</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['orderList'] as $order)
                <tr>
                    <td class="uk-text-bold">                                    
                        {{$order->person_firstname}} {{$order->person_lastname}}
                    </td>
                    <td>{{DateTimeHelper::DateTime($order->created_at)['time']}}</td>
                    <td>{{$order->order_total_cost}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('partial.paginationPartial', ['paginator' => $data['orderList']])