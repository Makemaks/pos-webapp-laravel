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
                    //alert(data.success);
                    cartCountID.innerText = quantity;
                    setFocus('barcodeInputID');
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
        
            cartCountID.innerText = parseInt(cartCountID.innerText) - parseInt(quantityID.innerText);
            setFocus('barcodeInputID');
            document.getElementById('receiptID').innerHTML = data['html'];
            control(0);
        },
        error: function (data) {
        
        }
    });
  
    
}


//add a stock_id to cart
function Add(stock_id, stock_name, stock_price){
 
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
            stock_price: stock_price, 
            stock_quantity:stock_quantity, 
            stock_discount:'' },      
         success:function(data){
           //alert(data.success);
            cartCountID.innerText = parseInt(cartCountID.innerText) + parseInt(stock_quantity);
            setFocus('barcodeInputID');
            document.getElementById('receiptID').innerHTML = data['html'];
            
        }
      });
     
    
 }



  //get
function GetScheme(user_id){

    $.ajax({        
        url:"/scheme-api/",
        method: 'GET',
        data: {user_id:user_id},      
        success:function(data){
          document.getElementById('scheme-id').innerHTML = data['html']; 
          
       }
     });
}

  //get
  function ApplyScheme(scheme_id){
    var schemeCountID = document.getElementById('schemeCountID'); 
    var totalPriceID = document.getElementById('totalPriceID'); 
    var receiptButtonID = document.getElementById('receiptButtonID'); 
    var totalPrice = totalPriceID.innerText;


    var schemePlanSelectID = document.getElementById('schemePlanSelectID-'+stock_id);
    var plan = null;
    

    if(schemePlanSelectID.selectedIndex > 0){
       plan =  schemePlanSelectID.value;
    }

    $.ajax({        
            url:"/cart-api/",
            method: 'GET',
            data: {scheme_id:scheme_id, totalPrice:totalPrice},      
            success:function(data){
                if(schemeCountID.innerText == ""){
                    schemeCountID.innerText = 0;
                }
                schemeCountID.innerText = parseInt(schemeCountID.innerText) + 1;
                totalPriceID.innerText = data['discount'].toFixed(2);
                receiptButtonID.innerText = data['discount'].toFixed(2);
            }
     });
    
   
}



function DiscountCode(){
    var planCountID = document.getElementById('planCountID'); 
    var discountCodeID = document.getElementById('discountCodeID');
    var totalPriceID = document.getElementById('totalPriceID'); 
    var receiptButtonID = document.getElementById('receiptButtonID'); 
    var totalPrice = totalPriceID.innerText;

    $.ajax({        
        url:"/cart-api/",
        method: 'GET',
        data: { plan_discount_code: discountCodeID.value, totalPrice:totalPrice },
        success:function(data){
            if(planCountID.innerText == ""){
                planCountID.innerText = 0;
            }
            planCountID.innerText = parseInt(planCountID.innerText) + 1;
            totalPriceID.innerText = data['discount'].toFixed(2);
            receiptButtonID.innerText = data['discount'].toFixed(2);
            discountCodeID.value = "";
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
   
   if (element.id == 'barcodeInputID') {
        $.ajax({        
                url:"/cart-api",
                method: 'POST',
                data: {barcode: element.value},      
                success:function(data){
                document.getElementById('receiptID').innerHTML = data['html'];
                cartCountID.innerText++;
                element.value = '';
                setFocus(element.id);
            }
        });
   } 
   else if(element.id == 'searchInputID') {
        $.ajax({        
                url:"/cart-api",
                method: 'POST',
                data: {search_element: element.value},      
                success:function(data){
                document.getElementById('receiptID').innerHTML = data['html'];
                cartCountID.innerText++;
                element.value = '';
                setFocus(element.id);
            }
        });
   }

}

function showInputKeypad(element){
   
    showKeypad(element);
}

function update(element){

    var value = document.getElementById(sessionStorage.getItem('inputID')).value;

   if (value  != '') {
        $.ajax({        
                url:"/cart-api",
                method: 'POST',
                data: {
                    type:  element.innerHTML.toLowerCase(),
                    value: value
                },      
                success:function(data){
                document.getElementById('receiptID').innerHTML = data['html'];
                document.getElementById(sessionStorage.getItem('inputID')).value = "";
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

function finaliseKey(order_finalise_key){
   
    $.ajax({        
        url:"/cart-api",
        method: 'GET',
        data: {
            order_finalise_key: order_finalise_key
        },      
        success:function(data){
            document.getElementById('contentID').innerHTML = data['html']; 
        }
    });
  
}   

var tags = jSuites.tags(document.getElementById('order-email-cc'), {
    value: 'cc',
    validation: function(element, text, value) {
        if (! value) {
            value = text;
        }
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        var test = re.test(String(value).toLowerCase()) ? true : false;
        return test;
    }
});





