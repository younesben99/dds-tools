(function($) {

    
    $(document).ready(function(){
   
        if($(".dds_car_search_merk").length){
            $(".dds_car_search_merk").select2();
        }
        if($(".dds_car_search_model").length){
            $(".dds_car_search_model").select2();
        }
        if($(".dds_car_search_brandstof").length){
            $(".dds_car_search_brandstof").select2();
        }
        var gekozenwagen = "";
        var gekozenbrandstof = "";
        var laatstgekozenmake = "";
        var car_search_finalurl = "/autos/";


        function dds_search_link(gekozenwagen,gekozenbrandstof){
            if(gekozenwagen == undefined || gekozenwagen == "" || gekozenwagen == null){
                gekozenwagen = "";
            }
            if(gekozenbrandstof == undefined || gekozenbrandstof == "" || gekozenbrandstof == null){
                gekozenbrandstof = "";
            }
            if(gekozenwagen !== "" && gekozenbrandstof == ""){
                car_search_finalurl = "/autos/?_merkenmodel="+gekozenwagen.toLowerCase();
                
            }
            if(gekozenwagen !== "" && gekozenbrandstof !== ""){
                car_search_finalurl = "/autos/?_merkenmodel="+gekozenwagen.toLowerCase()+"&?_brandstof="+gekozenbrandstof.toLowerCase();
            }
            if(gekozenwagen == "" && gekozenbrandstof !== ""){
                car_search_finalurl = "/autos/?_brandstof="+gekozenbrandstof.toLowerCase();
            }
            if(gekozenwagen == "" && gekozenbrandstof == ""){
                car_search_finalurl = "/autos/";
            }
            console.log(car_search_finalurl);
            
        }

        
        $(".dds_car_search_merk").on('change', function() {
            
            $(".dds_car_search_model").children('option').hide();
            var parentid = $('option:selected', this).attr("data-term-id");
            
            gekozenwagen = $('option:selected', this).attr("data-slug");
            laatstgekozenmake = $('option:selected', this).attr("data-slug");
           
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

            dds_search_link(gekozenwagen,gekozenbrandstof);
        
        });

        $(".dds_car_search_model").on('change', function() {

            var modelslug = $('option:selected', this).attr("data-slug");



            if(modelslug !== undefined && modelslug !== null && modelslug !== ""){
                gekozenwagen = modelslug;
                dds_search_link(gekozenwagen,gekozenbrandstof);
                
            }
            if(laatstgekozenmake !== "" && laatstgekozenmake !== undefined && modelslug == ""){
                
                dds_search_link(laatstgekozenmake,gekozenbrandstof);
            }
            

        });
        $(".dds_car_search_brandstof").on("change",function(){

            gekozenbrandstof = $(this).val();
            dds_search_link(gekozenwagen,gekozenbrandstof);
           

        });

        $(".dds_car_search_submit").on("click",function(e){
            e.preventDefault();

            window.location.href = car_search_finalurl;
            
        });
    });
})(jQuery);