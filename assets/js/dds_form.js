Dropzone.autoDiscover = false;
jQuery(document).ready(function($){

    //dropzone

    
    var dropzonemap = $("input[name=dropzone_map]").val();
    if($("#dds_dropzone").length){
        var myDropzone = new Dropzone("#dds_dropzone", {
            url: "/wp-content/plugins/dds-tools/modules/forms/dropzone_ajax.php",
            acceptedFiles: "image/*",
            maxFiles: 15,
            maxFilesize: 8, // MB
            uploadMultiple: true,
            parallelUploads: 100, // use it with uploadMultiple
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
                  $("#message").append("<div class='alert alert-success'>Foto geupload!</div>");
              } else {
                  $("#message").append("<div class='alert alert-danger'>Probleem bij het uploaden. Probeer een andere foto.</div>");
              }
            }
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
                
                //$(currentform).after("");
                $(currentform).find(".dds_form_submit").removeClass("dds_form_loading");
                $(currentform).find(".dds_form_submit").prop( "disabled", false );

                

                if($(currentform).hasClass("main_level1")){
                    console.log("conversie");
                    if($(".main_level2").length){
                        $(".main_level1").hide();
                        $(".main_level2").show();
                    }else{
                        $(currentform).parents().find(".dds_form_thankyou_notice").slideDown();
                    }

                }
                if($(currentform).hasClass("main_level2")){
                 
                    console.log("tweede conversie");
                    $(currentform).parents().find(".dds_form_thankyou_notice").slideDown();

                }
                

                
            }

            else{
                $(currentform)[0].submit();
                $(currentform).find(".dds_form_submit").prop( "disabled", false );
                $(currentform).parents().find(".dds_form_error_notice").slideDown();
                $(currentform).find(".dds_form_submit").removeClass("dds_form_loading");
            }
        })
        .fail(function() {
            $(currentform).find(".dds_form_submit").prop( "disabled", false );
            $(currentform).parents().find(".dds_form_error_notice").slideDown();
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
       var currentmerk = $(this).find("option:selected").attr("data-merk");
       var currentmerkval = $(this).parents().find("#dds_id_merk").val();
       $('.merklevel2').val(currentmerkval);
        $('select[name=model] option[selected="selected"]').each(
            function() {
                $(this).removeAttr('selected');
            }
        );
        $("select[name=model] option:first").attr('selected','selected');
        $("select[name=model] option").hide();
        
        $("select[name=model]").prop('disabled', false);
        
        $("select[name=model]").find("option[data-parent="+currentmerk+"]").each(function(){
            $(this).show();
        });
        $(".andermodel").show();

    });
    $("select[name=model]").on("change",function(){

        
        var currentmodel = $(this).val();
       
       
        $('.modellevel2').val(currentmodel);

    });



    

});