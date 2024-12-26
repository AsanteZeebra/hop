<script>
    
  $(function (){
  
   //-------------
   //- BAR CHART -
   //-------------
   
   var barChartCanvas = $('#bar').get(0).getContext('2d')
   var barChartData = {
     labels: <?php echo json_encode($stt); ?>,
     datasets: [
       {
        label:"Paid",
         data: <?php echo json_encode($ctt); ?>,
         backgroundColor : ['#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a','#00a65a'],
       },
       {
        label:"Unpaid",
         data: <?php echo json_encode($ct1); ?>,
         backgroundColor : [ '#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00','#B30B00'],
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