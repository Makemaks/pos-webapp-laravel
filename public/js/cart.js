$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//quantity plus and minus
function Quantity(buttonType, cartValue){
    var quantityID = document.getElementById('quantityID-'+cartValue);
  
  
  
    var cartCountID = document.getElementById('cartCountID');
   
        if (buttonType == 0 && cartCountID) {   
            //minnus        
            quantity = parseInt(cartCountID.innerText) - 1;
            quantityID.innerText = parseInt(quantityID.innerText) - 1;
        }
        else if (buttonType == 1 && cartCountID) {    
            //plus
            quantity = parseInt(cartCountID.innerText) + 1;
            quantityID.innerText = parseInt(quantityID.innerText) + 1;
        }

        if (quantity > 1) {

            $.ajax({        
                url:"cart-api/"+cartValue,
                method: 'PATCH',
                data: {stock_quantity: quantityID.innerText},      
                success:function(data){
                    /* alert(data.success);
                    setFocus('barcodeInputID'); */
                    cartCountID.innerText = quantity;
                    
                    document.getElementById('receiptID').innerHTML = data['html'];
                    control(0);
                }
            });
        }
}



//cart controls
function control(type){

  
    var edit_cart = true;

    if (type == 1) {
        //hide controls hidden = true
        edit_cart = false;
    }

    $.ajax({
        url:"/cart-api",
        method: 'GET',
        data: {edit_cart: edit_cart},   
        success: function (data) {
            document.getElementById('receiptID').innerHTML = data['html'];
            //control(0);

            if (type == 0) {
                //show controls hidden = true
                document.getElementById('controlHideID').hidden = false;
                document.getElementById('controlShowID').hidden = true;      
            } else {           
                document.getElementById('controlShowID').hidden = false;
                document.getElementById('controlHideID').hidden = true; 
               
            }
        },
        error: function (data) {
        
        }
    });
   
}

function Delete(row_id){

    //update basket count
    var quantityID = document.getElementById('quantityID-'+row_id);
    var cartCountID = document.getElementById('cartCountID'); 
  

    $.ajax({
        url:"/cart-api/" + row_id,
        method: 'DELETE',
        data: {quantity: quantityID.innerText},   
        success: function (data) {
        
            //setFocus('barcodeInputID');

            cartCountID.innerText = parseInt(cartCountID.innerText) - parseInt(quantityID.innerText);
           
            document.getElementById('receiptID').innerHTML = data['html'];
            control(0);
        },
        error: function (data) {
        
        }
    });
  
    
}


//add a stock_id to cart
function Add(stock_id, stock_name, stock_cost){
 
     //update basket count
     var cartCountID = document.getElementById('cartCountID'); 
     //var stock_quantity = document.getElementById('quantityID-'+stock_id);
     var stock_quantity = 1;
     var plan = null;

    
 
     $.ajax({        
         url:"/cart-api/",
         method: 'POST',
         data: {
            stock_id: stock_id, 
            stock_name:stock_name, 
            stock_cost: stock_cost, 
            stock_quantity:stock_quantity, 
           },      
         success:function(data){
           /* alert(data.success);
           setFocus('barcodeInputID'); */
           
            cartCountID.innerText = parseInt(cartCountID.innerText) + parseInt(stock_quantity);
            document.getElementById('receiptID').innerHTML = data['html'];
            setFocus('searchInputID');
        }
      });
     
    
 }

function CalculateChange(){

    var changeValueID = document.getElementById('changeValueID'); 
    var totalPriceID = document.getElementById('totalPriceID'); 
    var changeID = document.getElementById('changeID'); 

    var output = changeValueID.value - totalPriceID.innerText;
    changeID.innerText = output.toFixed(2);
   
}

function ClearSelect(select){
    var select = document.getElementById(select);
    var length = select.options.length;

    for (i = length-1; i >= 0; i--) {
      select.options[i] = null;
    }

    var option = document.createElement("option");
    option.id = 0;
    option.text = 'Select ...';
    option.disabled = true;
    select.add(option);
}

function setFocus(elementID){
    document.getElementById(elementID).focus();
}

function searchInput(element)
{
    var cartCountID = document.getElementById('cartCountID'); 
   
   if (element.value) {
        $.ajax({        
            url:"/cart-api",
            method: 'GET',
            data: {searchInputID: element.value}, 
            success:function(data){

                if (data['view'] == 'receiptID') {
                    document.getElementById(data['view']).innerHTML = data['html'];
                    cartCountID.innerText++;
                    element.value = '';
                } else {
                    document.getElementById(data['view']).innerHTML = data['html'];
                    element.value = '';
                }
                setFocus(element.id);
            }
        });
   }else{
        alert('No input');
   }

}

function showInputKeypad(element){
   
    showKeypad(element);
}

function update(element){

    //var value = document.getElementById(sessionStorage.getItem('inputID')).value;
    var value = document.getElementById(element.id).value;

   if (value  != '') {
        $.ajax({        
                url:"/cart-api",
                method: 'POST',
                data: {
                    type:  element.innerHTML.toLowerCase(),
                    value: value,
                },      
                success:function(data){
                    document.getElementById(data['view']).innerHTML = data['html'];
                    setFocus(element.id);
                }

                
        });
   }
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
                url:"/cart-api",
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

function emptyFields(elementID){
    var elements = document.getElementsByTagName(elementID);
    for (var ii=0; ii < elements.length; ii++) {
        if (elements[ii].type == "text") {
            elements[ii].value = "";
        }
    }
}







