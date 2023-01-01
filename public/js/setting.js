$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function IndexSetting(){

    var settingKeyFormID = $("#settingKeyFormID").serialize();
   
    $.ajax({        
        url:"/setting-api",
        method: 'GET',
        data:{
            settingKeyFormID:settingKeyFormID,
        },
        success:function(data){
            document.getElementById('settingKeyFormID').innerHTML = data['html']; 
        }
    });
    
}

function StoreSettingKey(){

    var settingKeyFormID = $("#settingKeyFormID").serialize();
    var cartFormID = $("#cartFormID").serialize();
    
    $.ajax({        
        url:"/setting-api",
        method: 'POST',
        data:{
            settingKeyFormID:settingKeyFormID,
            cartFormID: cartFormID
        },
        success:function(data){
            if (data['html']) {
                document.getElementById('receiptID').innerHTML = data['html'];
            } 
        }
    });
    
}

function RemoveSettingKey(order_setting_key){

    $.ajax({        
        url:"/setting-api/"+order_setting_key,
        method: 'DELETE',
        data:{
            orderSettingKey:order_setting_key
        },
        success:function(data){
            document.getElementById('receiptID').innerHTML = data['html']; 
        }
    });
}