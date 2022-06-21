$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//quantity plus and minus
function Quantity(buttonType, cartValue, price){
    var quantityID = document.getElementById('quantityID-'+cartValue);
    var vatID = document.getElementById('vatID');
  
  
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
                data: {quantity: quantityID.innerText},      
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

    var cartListID = document.getElementById('cartListID');

    for (let index =0; index <= cartListID.children.length - 1; index++) {
        if (type == 0) {
            //show controls hidden = true
            document.getElementById('controlID-'+index).removeAttribute("hidden");
     
        } else {           
            document.getElementById('controlID-'+index).setAttribute("hidden", true);
        }
    
    }

    if (type == 0) {
        //show controls hidden = true
        document.getElementById('controlHideID').removeAttribute('hidden'); 
        document.getElementById('controlShowID').setAttribute('hidden', true);      
    } else {           
        document.getElementById('controlShowID').removeAttribute('hidden'); 
        document.getElementById('controlHideID').setAttribute('hidden', true); 
       
    }
   
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
function Add(stock_id, stock_name, stock_price, stock_vat){
 
     //update basket count
     var cartCountID = document.getElementById('cartCountID'); 
     //var stock_quantity = document.getElementById('quantityID-'+stock_id);
     var stock_quantity = 1;
     var plan = null;

    
 
     $.ajax({        
         url:"/cart-api/",
         method: 'POST',
         data: {stock_id: stock_id, stock_name:stock_name, stock_price: stock_price, stock_vat,stock_quantity:stock_quantity },      
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

function ApplyScheme(){
    var schemePlanSelectID = document.getElementById('schemePlanSelectID-'+stock_id);
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


function numpad(element){
    var searchInputID = document.getElementById('searchInputID');

    setFocus('searchInputID');
   
    if (element.innerText == 'C') {
         searchInputID.value = '';
    } 
    else if (element.innerText == 'BACK') {
        let str =  searchInputID.value;
         searchInputID.value = str.slice(0, -1);
    } 
    else if (element.innerText == 'Shift') {
        let str =  searchInputID.value;
         searchInputID.value = str.slice(0, -1);
    } 
    else {
         searchInputID.value =  searchInputID.value + element.innerText;
    }
  
}




