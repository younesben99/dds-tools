(function($) {
    $(document).ready(function(){
   
        var gekozenwagen = "";
        $(".dds_car_search_merk").on('change', function() {
            
            $(".dds_car_search_model").children('option').hide();
            var parentid = $('option:selected', this).attr("data-term-id");
            
            gekozenwagen = $('option:selected', this).attr("data-slug");
            $(".dds_car_search_choose_model").show();
            $(".dds_car_search_choose_model").prop('selected', true);

            var modelcount = 0;
            $(".dds_car_search_model").children('option').each(function( index ) {

                if($(this).attr("data-parent-id") == parentid){

                $(this).show();
                modelcount += 1;
                
                }

            });



            if(modelcount !== 0){
                $(".dds_car_search_model").prop("disabled", false);
            }
            else{
                $(".dds_car_search_model").prop("disabled", true);
            }
        
        });

        $(".dds_car_search_model").on('change', function() {

            var modelslug = $('option:selected', this).attr("data-slug");
            if(modelslug !== undefined && modelslug !== null){
                gekozenwagen = modelslug;
            }
            

        });

        $(".dds_car_search_submit").on("click",function(e){
            e.preventDefault();

            if(gekozenwagen !== ""){
                window.location.href = "/autos/?_merkenmodel="+gekozenwagen;
            }
            else{
                window.location.href = "/autos/";
            }

        });
    });
})(jQuery);