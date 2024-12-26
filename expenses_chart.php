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
        label:'Income',
         data: <?php echo json_encode($sam); ?>,
          backgroundColor : ['#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#85FCE0','#E44032','#4D5358','#2A5598','#B44ECF','#67275A','#27675A'],
       },
       {
        label:'Expenditure',
          data: <?php echo json_encode($sam1); ?>,
           backgroundColor : ['#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de','#85FCE0','#E44032','#4D5358','#2A5598','#B44ECF','#67275A','#27675A'],
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