Dropzone.autoDiscover = false;
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
  
jQuery(document).ready(function($){

    var conversieteller = 0;
    //dropzone

    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
      });
    
    if($("select").length){
        

        $("select").each(function(index,element){
            
          
            $(element).select2({
                placeholder: $(element)[0][0],
                allowClear: false,
                "language": {
                    "noResults": function(){
                        return "Geen resultaten gevonden";
                    }
                }
            });
        });
        
    }


    var dropzonemap = $("input[name=dropzone_map]").val();
    if($(".dropzone").length){

        $(".dropzone").each(function( index,element ) {

        
           
            new Dropzone(element, {
                url: "/wp-content/plugins/dds-tools/modules/forms/dropzone_ajax.php",
                acceptedFiles: "image/*",
                maxFiles: 15,
                maxFilesize: 8,
                uploadMultiple: true,
                parallelUploads: 100, 
                createImageThumbnails: true,
                thumbnailWidth: 120,
                thumbnailHeight: 120,
                addRemoveLinks: true,
                timeout: 180000,
                // Language Strings
                dictFileTooBig: "Huidige grootte: ({{filesize}}mb). Maximale bestandsgrootte: {{maxFilesize}}mb",
                dictInvalidFileType: "Ongeldig bestandstype: Upload .jpg of .png",
                dictCancelUpload: "Annuleren",
                dictRemoveFile: "&#10005;",
                dictMaxFilesExceeded: "Maximale aantal bestanden: {{maxFiles}}",
                dictDefaultMessage: "<img src='/wp-content/plugins/dds-tools/assets/images/add_img.png' style='width: 70px;opacity: 0.7;'><br><span style='color: #a1a1a1;'>Foto\'s toevoegen</span>",
                params: {'dropzone_map':dropzonemap},
                success:function(file, response){
                console.log("succes");
                  if (response == "true") {
                      $(element).parents(".dds_form").find("#message").append("<div class='alert alert-success'>Foto geupload!</div>");
                  } else {
                     $(element).parents(".dds_form").find("#message").append("<div class='alert alert-danger'>Probleem bij het uploaden. Probeer een andere foto.</div>");
                  }
                }
            });
          });

        
    }
    else{
        dropzonemap = "";
    }
    

    $("select[name=model]").prop('disabled', 'disabled');

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
        
        var fields = $(this).find("input[type=text],input[type=tel],input[type=email],select,textarea,input[type=hidden]").map(function(){
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
                "formtype": formtype,
                "dropzone_map": dropzonemap
            }
    } )
        .done(function(data) {
            if(data == "verstuurd"){
                

                if(conversieteller == 0){
                    console.log("Conversie! " + formtype);
                    try {
                        gtag('event', "DDS Form verstuurd", {
                            'event_category': window.location.href,
                            'event_label': "Form: " + formtype,
                    });
                        
                    } catch (error) {
                        console.log(error);
                    }
                    
                    
                   
                    
                }
                conversieteller++;
                

                $(currentform).find(".dds_form_submit").removeClass("dds_form_loading");
                $(currentform).find(".dds_form_submit").prop( "disabled", false );

                

                if($(currentform).hasClass("main_level1")){
                    console.log("conversie");
                    if($(".main_level2").length){
                        $(".main_level1").hide();
                        $(".main_level2").show();
                    }else{
                        $(currentform).find(".dds_form_thankyou_notice").slideDown();
                    }

                }
                if($(currentform).hasClass("main_level2")){
                    try {
                        gtag('event', "DDS Form verstuurd", {
                            'event_category': window.location.href,
                            'event_label': "ClickForm: " + formtype,
                    });
                    } catch (error) {
                        console.log(error);
                        
                    }
                        
                        
                    console.log("tweede conversie");
                    $(currentform).find(".dds_form_thankyou_notice").slideDown();

                }
                

                
            }

            else{
                $(currentform)[0].submit();
                $(currentform).find(".dds_form_submit").prop( "disabled", false );
                $(currentform).find(".dds_form_error_notice").slideDown();
                $(currentform).find(".dds_form_submit").removeClass("dds_form_loading");
            }
        })
        .fail(function() {
            $(currentform).find(".dds_form_submit").prop( "disabled", false );
            $(currentform).find(".dds_form_error_notice").slideDown();
            $(currentform).find(".dds_form_submit").removeClass("dds_form_loading");
        });
        } catch (error) {
         $(formcatch)[0].submit();
         $(currentform).find(".dds_form_submit").prop( "disabled", false );
         $(currentform).parents().find(".dds_form_error_notice").slideDown();
        
        console.error(error);
          
        }
          
        
    });



    $("form .dds_input_group select,form .dds_input_group input").each(function(index){
        
        if(index == 0){
           
            $(this).on("change",function(){
                
                $(this).closest("form").find("*[data-hide=true]").each(function(){
                    //console.log($(this));
                    $(this).closest(".dds_input_group").slideDown();
                });
            });
        }
        
    });
    

    $("select[name=merk]").on("change",function(){
        var currentselect = $(this);
        var merkid = $(this).find("option:selected").attr("data-merk");
        $.post( "/wp-content/plugins/dds-tools/modules/forms/modellen.php", { "merkid": merkid }, function( data ) {
            
            $(currentselect).parents(".dds_form").find("select[name=model]").html("");
            $(currentselect).parents(".dds_form").find("select[name=model]").append("<option></option>");
            $(currentselect).parents(".dds_form").find("select[name=model]").append(data);
            $(currentselect).parents(".dds_form").find("select[name=model]").append("<option value='andere'>Andere</option>");
          });



        $("select[name=model]").prop("disabled",false);

       
    });

    //  $(document).on('keyup keydown', 'input.select2-search__field', function(e) {   
        
    //     console.log(capitalizeFirstLetter($(this).val())); 
    //     $(this).parents(".dds_input_group").find("select").append("<option>"+$(this).val()+"</option>");
       
    //  });

});