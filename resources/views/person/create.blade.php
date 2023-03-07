@extends('layout.master')

@push('scripts')
    <script src="{{asset('js/myapp.js')}}"></script> 
@endpush


@section('content')
<form method="POST" id="submitForm" action="{{ route('person.create') }}" class="uk-form-stacked">
    @csrf
    <div class="">
        @include('person.partial.createPartial')
    </div>
</form>
@endsection
