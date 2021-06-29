jQuery(document).ready(function($){
    
    $(".dds_form").on("submit",function(e){
        e.preventDefault();
        var formcatch = $(this);
        $(this).parents().find(".dds_form_error_notice,.dds_form_thankyou_notice").hide();
        try {
        
        $(this).find(".dds_form_submit").prop( "disabled", true );
        $(this).find(".dds_form_submit").addClass("dds_form_loading");
        
        var currentform = $(this);
        var formid = $(this).attr('id');
        var formtype = $(this).find('.dds_form_type').val();
        
        var fields = $(this).find("input[type=text],input[type=tel],input[type=email]").map(function(){
            var ddsval = $(this).val();
            var ddsname = $(this).attr("name");

            var fielddata = {};

            fielddata[ddsname] = ddsval;

            return [fielddata];
        }).get();

        $.ajax( {
            url: "/wp-content/plugins/dds-tools/modules/forms/form_ajax.php",
            method: "POST",
            data: {
                "fields":JSON.stringify(fields),
                "url": document.URL,
                "formtype": formtype
            }
    } )
        .done(function(data) {
            if(data == "verstuurd"){
                $(currentform).after("");
                $(currentform).find(".dds_form_submit").removeClass("dds_form_loading");
                $(currentform).find(".dds_form_submit").prop( "disabled", false );
                $(currentform).parents().find(".dds_form_thankyou_notice").slideDown();
            }

            else{
                $(currentform)[0].submit();
            }
        })
        .fail(function() {
            $(currentform).find(".dds_form_submit").prop( "disabled", false );
            $(currentform).parents().find(".dds_form_error_notice").slideDown();
        });
        } catch (error) {

          $(formcatch)[0].submit();
          console.error(error);
          
        }
          
        
        
        

    });
});