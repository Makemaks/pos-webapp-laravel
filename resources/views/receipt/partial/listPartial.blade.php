
@php
    $total = 0;
@endphp
<div>
    <table class="uk-table uk-table-small uk-table-divider">
        <thead>
        <tr> 
            <th>Receipt</th>           
            <th>Total</th> 
            <th></th>  
            <th></th>
        </tr>
        </thead>
        <tbody>
            @foreach ($data['cartList'] as $cartCount => $cart)
                    @php
                        $total = $total + $cart['stock_price'];
                    @endphp
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$total}}</td>
                    <td><a class="uk-button uk-button-default uk-text-danger" {{-- href="{{route('receipt.recover', $cartCount)}}" --}} uk-icon="icon: list"></a></td>
                    <td><a class="uk-button uk-button-default uk-text-danger" {{-- href="{{route('receipt.remove', $cartCount)}}" --}} uk-icon="icon: trash"></a></td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>