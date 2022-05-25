@php
// dd(Session::all());
@endphp

<div>
    <form id="{{ $table }}-pdf" action="{{ route('dashboard.index') }}" method="GET" style="display: inline">
        @csrf
        @if (Session::has('date'))
            <input type="hidden" name="started_at" value="{{ session('date')['started_at'] }}">
            <input type="hidden" name="ended_at" value="{{ session('date')['ended_at'] }}">
        @endif
        @if (Session::has('user'))
            <input type="hidden" name="started_at" value="{{ session('user')['started_at'] }}">
            <input type="hidden" name="ended_at" value="{{ session('user')['ended_at'] }}">
            <input type="hidden" name="user_id" value="{{ session('user')['user_id'] }}">
        @endif
        <input type="hidden" name="fileName" value="{{ $table }}">
        <input type="hidden" name="format" value="pdf">
        <button class="uk-button uk-button-danger button-pdf" form="{{ $table }}-pdf">Export To PDF</button>
    </form>

    <form id="{{ $table }}-csv" action="{{ route('dashboard.index') }}" method="GET" style="display: inline">
        @csrf
        <input type="hidden" name="fileName" value="{{ $table }}">
        <input type="hidden" name="format" value="csv">
        <button class="uk-button uk-button-danger button-pdf" form="{{ $table }}-csv">Export To CSV</button>
    </form>
</div>
