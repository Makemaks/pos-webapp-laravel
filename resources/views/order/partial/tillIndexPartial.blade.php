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
        <div>Start Date * <input type="date" required name="start_date" class="uk-input"></div>
        <div>End Date *<input type="date" required name="end_date" class="uk-input"></div>
        {{-- <div>Start Time<input type="time" name="start_time" class="uk-input"></div>
        <div>End Time<input type="time" name="end_time" class="uk-input"></div> --}}
        <div>Check<input type="number" name="check" class="uk-input"></div>
        <div>Table<input type="number" name="table" class="uk-input"></div>
        <div>
            Department
            <select class="uk-select" name="department" id="form-stacked-select">
                <option>Choose One Department</option>
                @foreach($stocks as $stock)
                    <option>{{$stock->stock_set['category_id']}}</option>
                @endforeach
            </select>
        </div>
        <div>
            Group
            <select class="uk-select" name="group" id="form-stacked-select">
                <option>Option 01</option>
                <option>Option 02</option>
            </select>
        </div>
        <div>
            Clerk
            <select class="uk-select" name="clerk" id="form-stacked-select">
                <option>Choose One Clerk</option>
                @foreach($clerks as $clerk)
                <option value="{{$clerk->user_id}}">{{$clerk->UserPerson->person_name['person_firstname']}}</option>
                @endforeach
            </select>
        </div>
        <div>
            Price Level
            <select class="uk-select" name="price_level" id="form-stacked-select">
                <option>Option 01</option>
                <option>Option 02</option>
            </select>
        </div>
        <div>
            Terminal
            <select class="uk-select" name="terminal" id="form-stacked-select">
                <option>Option 01</option>
                <option>Option 02</option>
            </select>
        </div>
        <div>
            Till Location
            <select class="uk-select" name="till_location" id="form-stacked-select">
                <option>Option 01</option>
                <option>Option 02</option>
            </select>
        </div>
        <div style="
        margin-top: 62px;"><button
                class="uk-button uk-button-default uk-border-rounded uk-button-primary">Submit</button>
            <button type="reset" class="uk-button uk-button-default uk-border-rounded uk-button-primary">Reset</button>
        </div>
    </div>

</form>
<div class="" uk-height-viewport="offset-top: true; offset-bottom: 50px">
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
    <div class="uk-margin-large">
        @isset($data['orderList'])
        @include('partial.paginationPartial', ['paginator' => $data['orderList']])
        @endisset
    </div>
</div>
