@if ($data['personModel'])
    <div  class="uk-overflow-auto uk-height-large" uk-height-viewport="offset-top: true; offset-bottom: 10">
        <div class="uk-child-width-1-2" uk-grid>
            <div>
                @include('person.partial.createPartial')
            </div>
            <div>
                @include('company.partial.createPartial')
            </div>
        </div>
    </div>
    
@else
    <p class="uk-text-danger">No Customer added</p>
@endif
