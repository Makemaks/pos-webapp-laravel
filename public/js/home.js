function stockGroup(id, type, view){

    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            id:id,
            type:type,
            view:view
        },      
        success:function(data){
            document.getElementById('contentID').innerHTML = data['html'];
            if (!view) {
                document.getElementById("stockGroupID").hidden = false;
            }
        }
     });

}

function showCustomer(){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'showCustomer'},      
        success:function(data){
         
           document.getElementById('contentID').innerHTML = data['html']; 
       }
     });

}

function removeCustomer(){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'removeCustomer'},      
        success:function(data){
         
            //showStock();
            document.getElementById('receiptID').innerHTML = data['html']; 
            
       }
     });

}

function useCustomer(person_id){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            action: 'useCustomer',
            value:person_id
        },      
        success:function(data){
           document.getElementById('receiptID').innerHTML = data['html']; 
       }
     });

}



function searchCustomer(element){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            value: element.value,
            action: 'searchCustomer'
        },      
        success:function(data){
         
           document.getElementById('searchResultID').innerHTML = data['html']; 
       }
     });

}


function createCustomer(){

     
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'createCustomer'},      
        success:function(data){
         
           document.getElementById('contentID').innerHTML = data['html']; 
       }
     });

}


function showStock(){

     
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'showStock'},      
        success:function(data){
           document.getElementById('contentID').innerHTML = data['html']; 
           document.getElementById("stockGroupID").hidden = true;
       }
     });

}

function showOrder(){

     
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'showOrder'},      
        success:function(data){
           document.getElementById('contentID').innerHTML = data['html']; 
           //document.getElementById("stockGroupID").hidden = true;
       }
     });

}

function pagination(page, action, view){
    

    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            page: page,
            action:action,
            view:view
        },      
        success:function(data){
        document.getElementById('contentID').innerHTML = data['html']; 
        //document.getElementById("stockGroupID").hidden = true;
    }
    });

}


function addRefund(element){

    showKeypad();
    sessionStorage.setItem('buttonType', element.innerText);
   
    if (sessionStorage.getItem('buttonType') == 'Enter') {
        $.ajax({        
            url:"/home-api",
            method: 'GET',
            data: {action: 'showKeypad'},      
            success:function(data){
             
               document.getElementById('contentID').innerHTML = data['html']; 
           }
         });
    }

}

function settingFinaliseKey(setting_finalise_key){
   
    var cartCountID = document.getElementById('cartCountID'); 

   if (cartCountID.innerText > 0) {
        if (setting_finalise_key == 'cancel') {
            document.getElementById('payButtonID').hidden = false;
            document.getElementById('cancelButtonID').hidden = true;
            document.getElementById('confirmButtonID').hidden = true;
        }
        else {
            $.ajax({        
                url:"/home-api",
                method: 'GET',
                data: {
                    setting_finalise_key: setting_finalise_key
                },      
                success:function(data){
                    document.getElementById('contentID').innerHTML = data['html']; 
                    document.getElementById('cancelButtonID').hidden = false;
                    document.getElementById('confirmButtonID').hidden = false;
                    document.getElementById('payButtonID').hidden = true;
                    setFocus('searchInputID');
                    // /emptyFields("input");

                    
                }
            });
        }
   }
  
}  



function showSetupList(type){
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            action: "setupList",
            type: type
        },      
        success:function(data){
            document.getElementById('contentID').innerHTML = data['html']; 
        }
    });
}



