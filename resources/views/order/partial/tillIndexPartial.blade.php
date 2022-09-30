@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush
@php
use App\Models\Store;
use App\Models\Person;
@endphp
<div class="" uk-height-viewport="offset-top: true; offset-bottom: 50px">
    <div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>ReportID</th>
                    <th>Site</th>
                    <th>Till</th>
                    <th>Clerk</th>
                    <th>Mode</th>
                    <th>Period</th>
                    <th>Code</th>
                    <th>MC No</th>
                </tr>
            </thead>
            <tbody>
                {{-- @dd($data['orderList']) --}}
                    @foreach($data['orderList'] as $orderList) 
                    @php 
                        $storeName = Store::where('store_id',$orderList->store_id)->pluck('store_name')->first();
                        $personName = Person::where('person_id',$orderList->user_person_id)->pluck('person_name')->first();
                    @endphp
                        <tr>
                            <td>{{$orderList->created_at}}</td>
                            <td></td>
                            <td>{{$storeName}}</td>
                            @foreach($tillData as $tillKey => $till)
                                @if(isset($tillKey) && $tillKey == $orderList->order_setting_pos_id)
                                    <td>{{$till['name']}}</td>
                                @endif
                            @endforeach
                            <td>{{$personName['person_firstname'].' '.$personName['person_lastname']}}</td>
                        </tr>
                    @endforeach
            </tbody>
        </table>
    </div>
    <div class="uk-margin-large">
        @isset($data['orderList'])
        @include('partial.paginationPartial', ['paginator' => $data['orderList']])
        @endisset
    </div>
</div>

