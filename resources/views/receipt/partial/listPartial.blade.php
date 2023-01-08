
@php
    $total = 0;
    if( Session::has('user-session-'.Auth::user()->user_id.'.waitingList') ){
       
       $data['waitingList'] = Session::get('user-session-'.Auth::user()->user_id.'.waitingList');

   }
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
            @isset($data['waitingList'])
                @foreach ($data['waitingList'] as $cartCount => $cart)
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
            @endisset
        </tbody>
    </table>
</div>