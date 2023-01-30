(function($) {

    $(window).on('pageshow', function(event) {
        if (event.originalEvent.persisted) {
          $("#dds_car_search_merk").val('select');
          $("#dds_car_search_model").val('select');
        
        }
      });
      
      $(window).on('popstate', function() {
        $("#dds_car_search_merk").val('select');
        $("#dds_car_search_model").val('select');
        
      });
    $(document).ready(function(){

  
    
        $("#dds_car_search_model").prop("disabled",true);

        var gekozenwagen = "";
        var gekozenwagen_model = "";
        var carcount = 0;
        $("#dds_car_search_merk").on("change",function(){

            

            gekozenwagen_model = "";
            carcount = 0;

            var chosen_merk = $(this).val();

            gekozenwagen = chosen_merk;



            $.post( "/wp-content/plugins/dds-tools/modules/search/get_model.php", { "merk": chosen_merk }, function( data ) {
            
                var options = JSON.parse(data);


                console.log(options);

                $("#dds_car_search_model").html(options[0]);
                $("#dds_car_search_model").prop("disabled",false);


         

            $("#search_carcount").html(options[1] - 1 );
              });



          
        });
        

      
        $("#dds_car_search_model").on("change",function(){
            
           
           var chosen_model = $('option:selected', this).val();
           gekozenwagen_model = chosen_model;

            carcount = 0;
            $("#dds_car_search_model option").each(function(){
                
                if($(this).val() == chosen_model){
                    carcount++;
                    

                }
               
            
            });

            if(carcount == 0){
                carcount++;
            }
           

            $("#search_carcount").html(carcount);

        });
        $("#dds_car_search_submit").on("click",function(e){
            
            e.preventDefault();

            if(gekozenwagen_model == ""){
                var car_search_finalurl = "/autos/?merk="+gekozenwagen;
            }
            else{
                var car_search_finalurl = "/autos/?merk="+gekozenwagen+"&model="+gekozenwagen_model;
            }
            
            window.location.href = car_search_finalurl;
            

        });

    });
})(jQuery);