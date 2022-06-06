<div>  

    {{-- <form id="formReceipt" action="{{route('payment.create')}}" method="POST">
        @csrf
        @method('GET')
        @include('receipt.partial.userPartial')
    </form> --}}

    <div>
        @include('receipt.partial.receiptPartial')
    </div>

    {{-- <ul uk-accordion="multiple: true">
        <li class="uk-open">
            <a class="uk-accordion-title" href="#"><h2><b>User</b> Receipt</h2></a>
            <div class="uk-accordion-content">
                <form id="formReceipt" action="{{route('payment.create')}}" method="POST">
                    @csrf
                    @method('GET')
                    @include('receipt.partial.userPartial')
                </form>
            </div>
        </li>
        <li class="uk-open">
            <a class="uk-accordion-title" href="#"><h2><b>Order</b> Receipt</h2></a>
            <div class="uk-accordion-content uk-container uk-container-xsmall">
                @include('receipt.partial.receiptPartial')
            </div>
        </li>
        <li>
            <a class="uk-accordion-title" href="#"><h2><b>Scheme</b> Receipt</h2></a>
            <div class="uk-accordion-content">
                @include('receipt.partial.schemePartial')
            </div>
        </li>
        <li>
            <a class="uk-accordion-title" href="#"><h2><b>Plan</b> Receipt</h2></a>
            <div class="uk-accordion-content">
                @include('receipt.partial.planPartial')
            </div>
        </li>
    </ul> --}}
    
</div>
