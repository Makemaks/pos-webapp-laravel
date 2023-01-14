@push('scripts')
<script src="{{ asset('js/app.js') }}"></script>
@endpush
@php
use App\Models\Store;
use App\Models\Person;
@endphp
<form class="uk-form" action="{{route('order.index')}}">
    @csrf
    @method('PUT')
    <div uk-grid>
        <div>Start Date * <input type="date" required name="start_date"  class="uk-input" ></div>
        <div>End Date *<input type="date" required name="end_date" class="uk-input" ></div>
        <div class="uk-margin-top"><button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
            <button  type="reset" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Reset</button></div>
    </div>
    <div uk-grid>
        {{-- <div>Start Time<input type="time" name="start_time" class="uk-input" ></div>
        <div>End Time<input type="time" name="end_time" class="uk-input" ></div> --}}
        {{-- <div class="uk-margin-top"><button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
            <button class="uk-button uk-button-default uk-border-rounded uk-button-primary">Reset</button></div> --}}
    </div>
</form>
<div class="" uk-height-viewport="offset-top: true; offset-bottom: 50px">
    <div class="uk-overflow-auto uk-height-small" uk-height-viewport="offset-top: true; offset-bottom: 30">
        <table class="uk-table uk-table-small uk-table-divider">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>BillID</th>
                    <th>Site</th>
                    <th>Table</th>
                    <th>Name</th>
                    <th>Check</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
             
                    @foreach($data['orderList'] as $orderList) 
                    @php 
                        $storeName = Store::where('store_id',$orderList->store_id)->pluck('store_name')->first();
                        $personName = Person::where('person_id',$orderList->user_person_id)->pluck('person_name')->first();
                    @endphp
                        <tr>
                            <td>{{$orderList->created_at}}</td>
                            <td></td>
                            <td>{{$storeName}}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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

