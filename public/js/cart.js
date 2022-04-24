$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//quantity plus and minus
function Quantity(buttonType, cartValue, price){
    var quantityID = document.getElementById('quantityID-'+cartValue);
    var vatID = document.getElementById('vatID');
  
    var receiptButtonID = document.getElementById('receiptButtonID');
    var cartValueID = document.getElementById('cartValueID');
    var totalPriceID = document.getElementById('totalPriceID');

        if (buttonType == 0 && quantityID.value >= 2) {   
            //minnus        
            quantityID.value = parseInt(quantityID.value) - 1;
            
            if(cartValueID){
                cartValueID.innerText = parseInt(cartValueID.innerText) - 1;
            }
          
        }
        else if (buttonType == 1 && quantityID.value >= 1) {    
            //plus
            quantityID.value = parseInt(quantityID.value) + 1; 
           
            if (cartValueID) {
                cartValueID.innerText = parseInt(cartValueID.innerText) + 1;
            }
        }

        if(receiptButtonID){
            //update total
           
            var total = parseFloat(receiptButtonID.innerText) - parseFloat(price);
            receiptButtonID.innerText = total.toFixed(2);
            totalPriceID.innerHTML = total.toFixed(2);

            $.ajax({        
                url:"cart-api/"+cartValue,
                method: 'PATCH',
                data: {quantityID: quantityID.value},      
                success:function(data){
                  //alert(data.success);
                  document.getElementById('cartCountID').innerText++;
               }
             });
        }

       
}

//cart controls
function Control(type){    
   
    var cartListID = document.getElementById('cartListID');
    var count = 0;
  

    while (count < cartListID.children.length-3) {
       
        if (type == 0) {
            //show controls hidden = true
            document.getElementById('controlID-'+count).removeAttribute('hidden');
     
        } else {           
            document.getElementById('controlID-'+count).setAttribute('hidden','');  
        }

        count++;
    }

    if (type == 0) {
        //show controls hidden = true
        document.getElementById('controlHideID').removeAttribute('hidden'); 
        document.getElementById('controlShowID').setAttribute('hidden','');      
    } else {           
        document.getElementById('controlShowID').removeAttribute('hidden'); 
        document.getElementById('controlHideID').setAttribute('hidden',''); 
       
    }
   
}


function Delete(cartCount, price){

    //update basket count
    var cartCountID = document.getElementById('cartCountID'); 
    

    //update total
    var receiptButtonID = document.getElementById('receiptButtonID');  
    var receiptButtonID = document.getElementById('receiptButtonID');
    var quantityID = document.getElementById('quantityID-'+ cartCount);
   
   
    //get quantity
    if(quantityID.value != ''){
        quantityXID.innerText = '';
        var priceQuantity = price * parseInt(quantityID.value); 
        cartCountID.innerText = parseInt(cartCountID.innerText) - parseInt(quantityID.value); 
    }
    else{
        var priceQuantity = parseFloat(price);
        cartCountID.innerText = parseInt(cartCountID.innerText) - 1; 
    }
   
   

    var total = parseFloat(receiptButtonID.innerText) - parseFloat(priceQuantity);
    receiptButtonID.innerText = total.toFixed(2);
  

    cartListID = document.getElementById('cartItemID-'+ cartCount);       
    cartListID.remove();

    $.ajax({
            type: "DELETE",
            url: 'cart-api/' + cartCount,
            success: function (data) {
               
             
            },
            error: function (data) {
               
            }
    });
  
    
}


function Update(){
    
     //update basket count
     var cartCountID = document.getElementById('cartCountID'); 

    $.ajax({        
        url:"/cart-api/",
        method: 'PUT',
        data: {product: product, name:name, price: price},      
        success:function(data){
          //alert(data.success);
           cartCountID.innerText++;
       }
     });
    
}

//add a product to cart
function Add(product, name, price){
 
     //update basket count
     var cartCountID = document.getElementById('cartCountID'); 
     var quantityID = document.getElementById('quantityID-'+product);
     var quantity = quantityID.value;
     var plan = null;

    
 
     $.ajax({        
         url:"/cart-api/",
         method: 'POST',
         data: {product: product, name:name, price: price, quantity:quantity, plan:plan },      
         success:function(data){
           //alert(data.success);
            cartCountID.innerText = parseInt(cartCountID.innerText) + parseInt(quantity);
            setFocus('barcodeinputID');
            quantityID.value = 1;
        }
      });
     
    
 }

 //remove
function Empty(product, name, price){
 
     //update basket count
     var cartCountID = document.getElementById('cartCountID'); 
    var quantity = 0;
 
     $.ajax({        
         url:"/cart-api/",
         method: 'POST',
         data: {product: product, name:name, price: price},      
         success:function(data){
           //alert(data.success);
            cartCountID.innerText++;
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

function ApplyProductScheme(){
    var schemePlanSelectID = document.getElementById('schemePlanSelectID-'+product);
     var plan = null;
     

     if(schemePlanSelectID.selectedIndex > 0){
        plan =  schemePlanSelectID.value;
     }
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

function setFocus(element_id){
    var element = document.getElementById(element_id);
    element.focus;
}

function GetInput(element)
{
    var cartCountID = document.getElementById('cartCountID'); 
   
    $.ajax({        
        url:"/cart-api/",
        method: 'POST',
        data: {barcode: element.value},      
        success:function(data){
         
           cartCountID.innerText++;
           setFocus(element.id);
       }
     });
}

