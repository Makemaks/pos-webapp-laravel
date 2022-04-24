@php
    $periodArray = [
        'Today' => '',
        'Yesterday' => '',
        'This Week' => '',
        'Last Week' => '',
        'This Month' => '',
        'Last Month' => '',
        'This Quarter' => '',
        'Last Quarter' => '',
    ];
@endphp

@push('scripts')
    <script src="{{asset('js/jsuites.js')}}"></script>
@endpush

<div uk-grid>
    <div>

        <label class="uk-form-label" for="form-stacked-text">PERIOD</label>   
        <select class="uk-select uk-width-expand">
            <option selected disabled>SELECT ...</option>
            @foreach ($periodArray as $key => $period)
                <option value="{{$period}}">{{$key}}</option>
            @endforeach
        </select>
    </div>

    <div>
        <label class="uk-form-label" for="form-stacked-text">START DATE</label>
        <input id="started-at" name="started_at" class="uk-input calendar" placeholder="Start Date" value="">
    </div>

    <div>
        <label class="uk-form-label" for="form-stacked-text">END DATE</label>
        <input id="ended-at" name="ended_at" class="uk-input calendar" placeholder="End Date" value="">
    </div>
    
    <div>
        <label class="uk-form-label" for="form-stacked-text"></label>
        <button class="uk-button uk-button-danger uk-border-rounded" type="submit">
            <span uk-icon="icon: plus"></span>
        </button>
    </div>

</div>

