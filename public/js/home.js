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


