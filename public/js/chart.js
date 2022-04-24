$.ajaxSetup({
  headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  }
});
//Chart.defaults.global.tooltips.enabled = false;

$(document).ready(function(){
    CurrentWeekSalePercentage();
    MonthlyYearlySale();
});

function MonthlyYearlySale(){
 
  $.ajax({        
    url:"/chart-api/",
    method: 'GET',
    data: {
      chartID:'monthlyYearlySale'
    },      
    success:function(data){
        var ctx = document.getElementById('monthlyYearlySale');
        var frameworks = ["React"];
        var rgbaArray = array_rgba(frameworks.length);
      
     
        for (let index = 0; index < data.length; index++) {
            var sum =   data[index]['sum'];
        }        
       
            new Chart(ctx, {
              type: 'bar',
              data: {
                labels: frameworks,
                datasets: [
                  {
                    label: '',
                    data: sum,
                    backgroundColor:  rgbaArray,
                    borderColor: rgbaArray,
                    borderWidth: 1
                  }
                ]
              }
            });
       
    }
  });

  
}

function CurrentWeekSalePercentage(){
 
  var ctx = document.getElementById('currentWeekSalePercentage');
  var rgbaArray = array_rgba(2);

  
  $.ajax({        
    url:"/chart-api/",
    method: 'GET',
    data: {
      chartID:'currentWeekSalePercentage'
    },      
    success:function(data){

   
      var dataArray = [data, (100-data)];

        new Chart(ctx, {
            type: 'doughnut',
            data: {
              labels: ['Progress', 'Target'],
              datasets: [
                {
                  label: "",
                  data: dataArray,
                  backgroundColor:  rgbaArray,
                  borderColor: rgbaArray,
                  borderWidth: 1
                }
              ],
              
            }
        });
        
       document.getElementById('currentWeekSalePercentageID').innerText = data.toString();
      
    }
  });

  
}

function array_rgba(count) {
    var color = new Array();
    for (var i = 0; i < count; i++ ) {
        color.push(random_rgba());
    }
    return color;
}

function random_rgba() {  
    var o = Math.round, r = Math.random, s = 255; 
    return 'rgba(' + o(r()*s) + ',' + o(r()*s) + ',' + o(r()*s) + ',' + r().toFixed(1) + ')';
}
