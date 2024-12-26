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
        label:'Present',
         data: <?php echo json_encode($sam); ?>,
          backgroundColor : ['#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
       },
       {
        label:'Absent',
          data: <?php echo json_encode($sam1); ?>,
           backgroundColor : ['#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032'],
        },
        {
        label:'Late',
          data: <?php echo json_encode($sam2); ?>,
           backgroundColor : ['#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F','#FFD14F'],
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
   
 })

</script>