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
          label: <?php echo json_encode($sy) ?>,
         data: <?php echo json_encode($sam); ?>,
          backgroundColor : ['#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#85FCE0'],
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
   
   var barChartCanvas = $('#bar').get(0).getContext('2d')
   var barChartData = {
     labels: <?php echo json_encode($sy); ?>,
     datasets: [
       {
        label:'Months Paid',
         data: <?php echo json_encode($sam); ?>,
         backgroundColor : ['#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#85FCE0'],
       },

      

     ]
   }
   var barChartOptions     = {
     maintainAspectRatio : false,
     responsive : true,
   }
   //Create pie or douhnut chart
   // You can switch between pie and douhnut using the method below.
   new Chart(barChartCanvas, {
     type: 'bar',
     data: barChartData,
     options: barChartOptions
   })
 })

</script>