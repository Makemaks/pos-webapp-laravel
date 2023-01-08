$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function IndexSetting(view = null){

    var settingKeyFormID = $("#settingKeyFormID").serialize();
    var cartFormID = $("#cartFormID").serialize();
   
    $.ajax({        
        url:"/setting-api",
        method: 'GET',
        data:{
            settingKeyFormID:settingKeyFormID,
            cartFormID: cartFormID,
            view:view
        },
        success:function(data){
            document.getElementById('settingKeyID').innerHTML = data['html']; 
        }
    });
    
}

function StoreSettingKey(view = null){

    var settingKeyFormID = $("#settingKeyFormID").serialize();
    var cartFormID = $("#cartFormID").serialize();
    
    $.ajax({        
        url:"/setting-api",
        method: 'POST',
        data:{
            settingKeyFormID:settingKeyFormID,
            cartFormID: cartFormID,
            view:view
        },
        success:function(data){
            document.getElementById('receiptID').innerHTML = data['html'];
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