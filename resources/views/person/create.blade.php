@extends('layout.master')

@push('scripts')
    <script src="{{asset('js/myapp.js')}}"></script> 
@endpush


@section('content')
<form method="POST" id="submitForm" action="{{ route('person.create') }}" class="uk-form-stacked">
    @csrf
    @method('PUT')
    <div class="">
        @include('person.partial.createPartial')
    </div>
    <button class="uk-button uk-button-default" type="submit">Save</button>
</form>
@endsection
