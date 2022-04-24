<div class="uk-background-default uk-padding uk-box-shadow-small">
    <div class="uk-child-width-1-2" uk-grid>
        <div>
            <p class="uk-text-lead uk-margin-remove-bottom">New Entries</p>
            <p class="uk-text-meta uk-margin-remove-top">More than +{{$data['orderNewList']->count()}}</p>
        </div>
        <div>
            <a class="uk-align-right uk-button uk-button-secondary" href="{{route('order.create')}}">
                <i class="fa fa-user-plus"></i>
            </a>
        </div>
    </div>
    <table class="uk-table uk-table-divider uk-table-small uk-text-small">
        <thead>
            <tr>
                <th>Company</th>
                <th>Type</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data['orderNewList'] as $order)
                <tr>
                    <td class="uk-text-bold">                                    
                        {{$order->person_firstname}}
                    </td>
                    <td>{{$order->company_name}}</td>
                    <td>{{$order->service_schedule_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@include('partial.paginationPartial', ['paginator' => $data['orderNewList']])