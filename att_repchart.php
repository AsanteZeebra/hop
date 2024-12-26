<script>
    
  $(function (){
   //-------------
   //- DONUT CHART -
   //-------------
   // Get context with jQuery - using jQuery's .get() method.
   var donutChartCanvas = $('#dot').get(0).getContext('2d')
   var donutData        = {
     labels: <?php echo json_encode($sy) ?>,
     datasets: [
       {
        label:'Male',
         data: <?php echo json_encode($sam); ?>,
          backgroundColor : ['#00a65a','#00a65a','#00a65a'],
       },
       {
        label:'Female',
          data: <?php echo json_encode($sam1); ?>,
           backgroundColor : ['#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032'],
        },
     ]
   }
 
   var donutOptions     = {
     maintainAspectRatio : false,
     responsive : true,
   }
   //Create pie or douhnut chart
   // You can switch between pie and douhnut using the method below.
   new Chart(donutChartCanvas, {
     type: 'bar',
     data: donutData,
     options: donutOptions
     
   })
   

   //-------------
   //- DONUT CHART -
   //-------------
   // Get context with jQuery - using jQuery's .get() method.
   var donutChartCanvas = $('#dot1').get(0).getContext('2d')
   var donutData        = {
     labels: <?php echo json_encode($ssy) ?>,
     datasets: [
       {
        label:'Male',
         data: <?php echo json_encode($ssam); ?>,
          backgroundColor : ['#00a65a','#00a65a','#00a65a'],
       },
       {
        label:'Female',
          data: <?php echo json_encode($ssam1); ?>,
           backgroundColor : ['#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032'],
        },
     ]
   }
 
   var donutOptions     = {
     maintainAspectRatio : false,
     responsive : true,
   }
   //Create pie or douhnut chart
   // You can switch between pie and douhnut using the method below.
   new Chart(donutChartCanvas, {
     type: 'line',
     data: donutData,
     options: donutOptions
     
   })
 })

</script>