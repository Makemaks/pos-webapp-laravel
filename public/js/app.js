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
    var popUp = 0;

    $('#screen-lock').on('mousedown mouseup mousemove onkeyup onkeydown', function(e){
        count = 0;
        popUp = 1;
        // isRefresh = true;
    });

    // var isRefresh = false;
    // setTimeout(function() {
    //     const lockTimerScreen= localStorage.getItem('lock_screen');
    //     // alert(lockTimerScreen);

    //     if(lockTimerScreen == 1) 
    //     {
    //           UIkit.modal('#modal-lock-screen-center', {
    //              escClose: false,
    //              bgClose: false,
    //          }).show();
 
    //         //  isRefresh = true;
    //     }
    // },100)

    setInterval(function() {
        // if(!isRefresh) {
            if(count)
            {
                if(lockScreen && !popUp)
                {
                    lockScreen =0;
                    count = 0;
                    popUp = 1;
                    UIkit.modal($('#modal-lock-screen-center'), {
                        escClose: false,
                        bgClose: false,
                    }).show();
                    // localStorage.setItem('lock_screen', 1);

                    $.ajax({        
                        url:"app-api/",
                        method: 'GET',
                        data: {
                            lock_screen_enabled: true,
                        },      
                        success:function(data){
                         alert('hello');
                        }
                    });  
                }
            } else {
                // alert(timer);
                count = 1;
                lockScreen = 1;
                popUp = 0;
            }
        // } else {
        //     isRefresh = false;
        //     popUp = 1;
        // }
    }, 10000); 



//     $('#lock-screen').click(function(){
//         UIkit.modal($('#modal-lock-screen-center')).show();
//   });
});

function lockScreen() {
    var modal = UIkit.modal('#modal-lock-screen-center', {
        escClose: false,
        bgClose: false,
    });

    modal.show();
}

