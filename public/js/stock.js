$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function IndexStock(){

    var stockFormID = $("#stockFormID").serialize();
   
    $.ajax({        
        url:"/stock-api",
        method: 'GET',
        data:{
            stockFormID:stockFormID,
        },
        success:function(data){
            document.getElementById('stockID').innerHTML = data['html']; 
        }
    });
    
}
