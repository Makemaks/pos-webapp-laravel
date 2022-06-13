@php


@endphp


<form id="formReceipt" action="{{route('receipt.create')}}" method="POST">
    @csrf
    @method('GET')


    <div>
        @include('receipt.partial.indexPartial')
    </div>

</form>

