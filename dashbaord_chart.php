<script>
    
  $(function (){


   //-------------
   //- DONUT CHART -
   //-------------
   // Get context with jQuery - using jQuery's .get() method.
   var donutChartCanvas = $('#line').get(0).getContext('2d')
   var donutData        = {
     labels: <?php echo json_encode($month) ?>,
     datasets: [
       {
        label:'Total',
         data: <?php echo json_encode($tot); ?>,
          backgroundColor : ['#00a65a','#FFD14F','#E44032','#8FBB47','#17CB53','#233F93','#7F7F4E','#343A40','#EE3C23','#11C3DC','#93B3AC','#433007'],
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
     type: 'doughnut',
     data: donutData,
     options: donutOptions
     
   })



   //-------------
   //- BAR CHART -
   //-------------
   // Get context with jQuery - using jQuery's .get() method.
   var donutChartCanvas = $('#dot').get(0).getContext('2d')
   var donutData        = {
     labels: <?php echo json_encode($sy) ?>,
     datasets: [
       {
        label:'General',
         data: <?php echo json_encode($sam); ?>,
          backgroundColor : ['#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
       },
       {
        label:'Men',
          data: <?php echo json_encode($sam1); ?>,
           backgroundColor : [ '#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12','#f39c12'],
        },
        {
        label:'Women',
          data: <?php echo json_encode($sam2); ?>,
           backgroundColor : ['#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef','#00c0ef'],
        },
        {
        label:'Youth',
          data: <?php echo json_encode($sam3); ?>,
           backgroundColor : ['#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032','#E44032',],
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