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

$(document).ready(function() {
    var count = 1;
    var lockScreen = 1;

    $('#screen-lock').on('mousedown mouseup mousemove onkeyup onkeydown', function(e){
        count = 0;
    });

    setInterval(function() {
        if(count)
        {
            if(lockScreen)
            {
                lockScreen =0;
                count = 0;
                UIkit.modal($('#modal-lock-screen-center')).show();
                /* $.ajax({        
                    url:"app-api/",
                    method: 'GET',
                    data: {
                        lock_screen: true
                    },      
                    success:function(data){
                        document.getElementById('lockScreenID').innerHTML = data['html'];
                        UIkit.modal($('#modal-lock-screen-center')).show();
                    }
                }); */
    
                
            }
        } else {
            count = 1;
            lockScreen = 1;
        }
    }, 3000); 

//     $('#lock-screen').click(function(){
//         UIkit.modal($('#modal-lock-screen-center')).show();
//   });
});

function lockScreen() {
    UIkit.modal($('#modal-lock-screen-center')).show();
}

