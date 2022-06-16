@php
$route = Str::before(Request::route()->getName(), '.');
@endphp

<div uk-grid>
    <div>
        <form id="{{ $table }}-pdf" action="{{ route($route . '.index') }}" method="GET">
            @csrf
            @if (Session::has('date'))
                <input type="hidden" name="started_at" value="{{ session('date')['started_at'] }}">
                <input type="hidden" name="title" value="{{ session('date')['title'] }}">
                <input type="hidden" name="ended_at" value="{{ session('date')['ended_at'] }}">
            @endif
            @if (Session::has('user'))
                <input type="hidden" name="started_at" value="{{ session('user')['started_at'] }}">
                <input type="hidden" name="ended_at" value="{{ session('user')['ended_at'] }}">
                <input type="hidden" name="user_id" value="{{ session('user')['user_id'] }}">
                <input type="hidden" name="title" value="{{ session('user')['title'] }}">
            @endif
            <input type="hidden" name="fileName" value="{{ $table }}">
            <input type="hidden" name="format" value="pdf">
            <button class="uk-button uk-button-danger uk-border-rounded" form="{{ $table }}-pdf">
                PDF</button>
        </form>
    </div>

   <div>
        <form id="{{ $table }}-csv" action="{{ route('dashboard.index') }}" method="GET">
            @csrf
            <input type="hidden" name="fileName" value="{{ $table }}">
            <input type="hidden" name="format" value="csv">
            <button class="uk-button uk-button-danger uk-border-rounded" form="{{ $table }}-csv">
                CSV</button>
        </form>
   </div>
</div>
