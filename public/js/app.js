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
    var screenlock = false;
  

    $('#screen-lock').on('mousedown mouseup mousemove onkeyup onkeydown', function(e){
        count = 0;
        popUp = 1;
       
    });

    setInterval(function() {
        
            if(count == 1)
            {
                   
                if (screenlock == false) {
                    var modal = UIkit.modal('#modal-lock-screen-center', {
                        escClose: false,
                        bgClose: false,
                    });
                    modal.show();
                    screenlock = true;

                    $.ajax({        
                        url:"app-api/",
                        method: 'GET',
                        data: {
                            lock_screen_enabled: true,
                        },      
                        success:function(data){
                            if (data['status'] == 'screenlock' && screenlock == true) {
                                clearInterval();
                            }
                        
                        
                        }
                    });  
                }
                
                   
                  
            } else {
                // alert(timer);
                count = 1;
                //lockScreen = 1;
              
            }
    }, 10000); 

});

function lockScreen() {
    var modal = UIkit.modal('#modal-lock-screen-center', {
        escClose: false,
        bgClose: false,
    });

    modal.show();
}



