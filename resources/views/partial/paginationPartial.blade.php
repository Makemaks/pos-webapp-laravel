@if (Str::contains($paginator->url(0), 'api'))
    @if ($paginator->lastPage() > 1)
        <ul class="uk-pagination uk-flex-center" uk-margin>
            <li class="{{ ($paginator->currentPage() == 1) ? ' uk-disabled' : '' }}">
                <button class="uk-button uk-button-text" onclick="pagination({{ $paginator->currentPage()-1 }}, '{{Session::get('action')}}', '{{Session::get('view')}}' )"> 
                    <span uk-pagination-previous></span> </button>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' uk-active' : '' }}">
                    <button class="uk-button uk-button-text" onclick="pagination({{$i}}, '{{Session::get('action')}}', '{{Session::get('view')}}') ">{{ $i }}</button>
                </li>
            @endfor
            <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' uk-disabled' : '' }}">
                <button class="uk-button uk-button-text" onclick="pagination({{ $paginator->currentPage()+1 }}, '{{Session::get('action')}}', '{{Session::get('view')}}') " >
                    <span uk-pagination-next></span></button>
            </li>
        </ul>
    @endif
@else
    @if ($paginator->lastPage() > 1)
        <ul class="uk-pagination uk-flex-center" uk-margin>
            <li class="{{ ($paginator->currentPage() == 1) ? ' uk-disabled' : '' }}">
                <a href="{{ $paginator->url($paginator->currentPage()-1) }}"> <span uk-pagination-previous></span> </a>
            </li>
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                <li class="{{ ($paginator->currentPage() == $i) ? ' uk-active' : '' }}">
                    <a href="{{ $paginator->url($i) }}">{{ $i }}</a>
                </li>
            @endfor
            <li class="{{ ($paginator->currentPage() == $paginator->lastPage()) ? ' uk-disabled' : '' }}">
                <a href="{{ $paginator->url($paginator->currentPage()+1) }}" ><span uk-pagination-next></span></a>
            </li>
        </ul>
    @endif
@endif







<script>
   
</script>