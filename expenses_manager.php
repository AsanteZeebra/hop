<script>
    $(function(){
    
    var Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000
        });
    
   
    
      $('.tdedit').on('click', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);


            var id = $('.td1').text(data[0]);
            var d2 = $('.td2').text(data[1]);
            var d3 = $('.td3').text(data[2]);
            var d4 = $('.td4').text(data[3]);
            var d5 = $('.td5').val(data[6]);
            var d6 = $('.tf6').val(data[0]);
            
                  
            
           
        })
        
          $('.btdel').on('click', function() {
            $tr = $(this).closest('tr');

            var data = $tr.children("td").map(function() {
                return $(this).text();
            }).get();

            console.log(data);


            var id = $('.ddt').val(data[0]);
          
           
        })
        
       

          $('.dbt').click(function () {
   delete_expenses();
          })

        $('.btt').click(function(){
           make_decision();
        })
        
        


        $('.btr').click(function() {
        refuse();
        })
         //method to save data
         function refuse() {

            var ff = new FormData();

            var ucode = $('.tf6').val();
        
        
        
            ff.append('refer',ucode);
           
    
            $.ajax({
                url: "reject.php",
                type: "POST",
                data: ff,
                contentType: false,
                cache: false,
                //dataType:"JSON",
                processData: false,
                success: function(data) {

                   
                  if(data !=0){
                    Toast.fire({
                        icon: 'success',
                        title: data
                    });
                  
                 
                    setTimeout(function(){
                        location.reload();
                    }, 1000)
                  }else{
                    Toast.fire({
                        icon: 'error',
                        title: "UNABLE TO DELETE TRANSACTION"
                    });
                  }
     
                },
                error: function(err) {
                    alert("In error: " + err.responseText);
                }
            });

        }
    
        
         //method to save data
        function make_decision() {

            var ff = new FormData();

            var ucode = $('.tf6').val();
        
        
        
            ff.append('refer',ucode);
           
    
            $.ajax({
                url: "decide.php",
                type: "POST",
                data: ff,
                contentType: false,
                cache: false,
                //dataType:"JSON",
                processData: false,
                success: function(data) {

                   
                  if(data !=0){
                    Toast.fire({
                        icon: 'success',
                        title: data
                    });
                  
                 
                    setTimeout(function(){
                        location.reload();
                    }, 1000)
                  }else{
                    Toast.fire({
                        icon: 'error',
                        title: "UNABLE TO RECORD TRANSACTION"
                    });
                  }
     
                },
                error: function(err) {
                    alert("In error: " + err.responseText);
                }
            });

        }

          //method to save data
          function delete_expenses() {
            var ff = new FormData();

            var ucode = $('.ddt').val();
        
        
        
            ff.append('refer',ucode);
           
    
            $.ajax({
                url: "delete_expenses.php",
                type: "POST",
                data: ff,
                contentType: false,
                cache: false,
                //dataType:"JSON",
                processData: false,
                success: function(data) {

                   
                  if(data !=0){
                    Toast.fire({
                        icon: 'success',
                        title: data
                    });
                  
                 
                    setTimeout(function(){
                        location.reload();
                    }, 1000)
                  }else{
                    Toast.fire({
                        icon: 'error',
                        title: "UNABLE TO RECORD TRANSACTION"
                    });
                  }
     
                },
                error: function(err) {
                    alert("In error: " + err.responseText);
                }
            });

          
        }
    
})
</script>