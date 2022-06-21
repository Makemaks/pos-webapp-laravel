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
        }
     });

}

function showCustomer(){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'show_customer'},      
        success:function(data){
         
           document.getElementById('contentID').innerHTML = data['html']; 
       }
     });

}

function useCustomer(person_id){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            action: 'use_customer',
            value:person_id
        },      
        success:function(data){
           document.getElementById('useCustomerID').innerHTML = data['html']; 
       }
     });

}



function searchCustomer(value){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {
            value: value,
            action: 'search_customer'
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
        data: {action: 'create_customer'},      
        success:function(data){
         
           document.getElementById('contentID').innerHTML = data['html']; 
       }
     });

}


function showKeypad(){

   
    $.ajax({        
        url:"/home-api",
        method: 'GET',
        data: {action: 'show_keypad'},      
        success:function(data){
         
           document.getElementById('contentID').innerHTML = data['html']; 
       }
     });

}