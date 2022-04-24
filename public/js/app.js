$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


function OrderStatus(element, order_id){


    $.ajax({        
            url:"/order-api/" + order_id,
            method: 'PATCH',
            data: {order_status:element.options[element.selectedIndex].value },      
            success:function(data){
            
        }
     });
}