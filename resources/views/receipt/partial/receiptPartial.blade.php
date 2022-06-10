@php


    /* $data['sessionCartList'] = collect($data['sessionCartList'])->pluck('product_id')

    if ($data['sessionCartList']) {
        $data['productList'] = Stock::whereIn('stock_id',$data['sessionCartList'] );
    } */

@endphp



{{-- <div class="uk-margin uk-child-width-1-2" uk-grid>
    <div>Offer(s) : <span id="schemeCountID"></div>
    <div>Discount(s) : <span id="planCountID"></div>
</div> --}}

<form id="formReceipt" action="{{route('receipt.create')}}" method="POST">
    @csrf
    @method('GET')


    <div>
        @include('receipt.partial.indexPartial')
    </div>

        {{-- <div> 
        <div class="uk-text-center">
            <img loading="lazy" src="{{asset('/storage/image/paypal.png')}}">
        </div>
    </div>   --}}
</form>

