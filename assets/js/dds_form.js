
Dropzone.autoDiscover = false;
function capitalizeFirstLetter(string) {
    return string.charAt(0).toUpperCase() + string.slice(1);
  }
function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}
 function get_time_between(start_range,end_range,interval){

    var interval_minutes = interval / 60;
    var ranges = [];
    dates = [];

    date_loop = new Date("01/01/1970 "+start_range);
    end_range = new Date("01/01/1970 "+end_range).toLocaleTimeString('nl-BE', {
        hour: '2-digit',
        minute: '2-digit',
      });


      ranges.push(date_loop.toLocaleTimeString('nl-BE', {
        hour: '2-digit',
        minute: '2-digit',
      }));
    while (date_loop.toLocaleTimeString('nl-BE', {
        hour: '2-digit',
        minute: '2-digit',
      }) !== end_range) {
        

        ranges.push(addMinutes(date_loop, interval_minutes).toLocaleTimeString('nl-BE', {
            hour: '2-digit',
            minute: '2-digit',
          }));
        
        date_loop = addMinutes(date_loop, interval_minutes);
        

        
    }




    return ranges;


 } 
jQuery(document).ready(function($){
    function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, "\\$&");
        var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, " "));
      }
    
      var source = "Direct bezoek"; // Default source
      var gclid = getParameterByName('gclid');
      var bingid = getParameterByName('msclkid');
      
      if (gclid) {
        source = 'Google Ads';
      } else if (bingid) {
        source = 'Bing Ads';
      }
    
      $('.source_hidden').val(source);
    
    //console.log("dds_forms.js");
    $("#js_active").val("js");

    var conversieteller = 0;
    //dropzone
    $(".dropzone_map_input").val(Math.random().toString(16).slice(2));


    $(document).on('select2:open', () => {
        document.querySelector('.select2-search__field').focus();
      });
    
    if($("select").length){

       


        $(".dds_form select").each(function(index,element){
            
          
            $(element).select2({
                placeholder: $(element)[0][0],
                allowClear: false,
                "language": {
                    "noResults": function(){
                        return "Geen resultaten gevonden";
                    }
                },
                templateResult: function(option) {
                    if(option.element && (option.element).hasAttribute('hidden')){
                       return null;
                    }
                    return option.text;
                 }
            });
        });
        
    }


    var dropzonemap = $("input[name=dropzone_map]").val();
    if($(".dropzone").length){

        $(".dropzone").each(function( index,element ) {

        
           
            new Dropzone(element, {
                url: dds_main_vars.siteurl + "/wp-content/plugins/dds-tools/modules/forms/dropzone_ajax.php",
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
                dictDefaultMessage: "<img src='"+dds_main_vars.siteurl+"/wp-content/plugins/dds-tools/assets/images/add_img.png' style='width: 70px;opacity: 0.7;'>",
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

    $(document).on("submit", ".dds_form", function(e) {
        e.preventDefault();
        var formcatch = $(this);
        $(this).parents().find(".dds_form_error_notice,.dds_form_thankyou_notice").hide();
        try {
        
        $(this).find(".dds_form_submit").prop( "disabled", true );
        $(this).find(".dds_form_submit").addClass("dds_form_loading");
        
        var currentform = $(this);
        var formid = $(this).attr('id');
        var formtype = $(this).find('.dds_form_type').val();
        
        var fields = $(this).find("input[type=radio]:checked,input[type=text],input[type=tel],input[type=email],select,textarea,input[type=hidden]").map(function(){
            var ddsval = $(this).val();
            var ddsname = $(this).attr("name");

            var fielddata = {};

            fielddata[ddsname] = ddsval;

            return [fielddata];
        }).get();
        console.log(fields);
        $.ajax( {
            url: dds_main_vars.siteurl+"/wp-content/plugins/dds-tools/modules/forms/form_ajax.php",
            method: "POST",
            data: {
                "fields":JSON.stringify(fields),
                "url": document.URL,
                "formtype": formtype,
                "dropzone_map": dropzonemap
            }
    } )
        .done(function(data) {
            
            if(data.trim() == "verstuurd"){
                

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
                    
                    //console.log("conversie");
                    if($(".main_level2").length){
                        $(".main_level1").hide();
                        $(".main_level2").show();
                        
                    }else{
                        $(currentform).find(".dds_form_thankyou_notice").slideDown();
                        setTimeout(function(){
                            var redirect = $(currentform).find(".dds_redirect").val(); 
                            //console.log(redirect);
                            if(redirect !== undefined && redirect !== "NO_REDIRECT"){
                                window.location.href = '/'+redirect;
                            }
                           
                          }, 2000);
                       
                    }

                }
                if($(currentform).hasClass("main_level2")){
                    //hier halen wij de redirect link op vanuit het eerst formulier, PREV wordt gebruikt dus verander de structuur vande forms niet
                    var redirect = $(currentform).prev().find(".dds_redirect").val(); 
                    
                    try {
                        gtag('event', "DDS Form verstuurd", {
                            'event_category': window.location.href,
                            'event_label': "ClickForm: " + formtype,
                    });

                    } catch (error) {
                        console.log(error);
                        
                    }
                    setTimeout(function(){
                        
                        
                        if(redirect !== undefined && redirect !== "NO_REDIRECT"){
                                window.location.href = '/'+redirect;
                            }
                      }, 2000);
                        
                    //console.log("tweede conversie");
                    $(currentform).find(".dds_form_thankyou_notice").slideDown();

                }
                

                
            }

            else{
               // $(currentform)[0].submit();
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
       //  $(formcatch)[0].submit();
         $(currentform).find(".dds_form_submit").prop( "disabled", false );
         $(currentform).parents().find(".dds_form_error_notice").slideDown();
        
        console.error(error);
          
        }
          
        
    });


 

    $(".dds_form select,.dds_form input").on("change",function(){
                
        $(this).closest("form").find("*[data-hide=true]").each(function(){
            if($(this).closest(".dds_input_group").is(":hidden")){
                //console.log($(this));
                $(this).closest(".dds_input_group").slideDown();
            }
            
        });
    });
    

    $("select[name=merk]").on("change",function(){
        var currentselect = $(this);
        var merkid = $(this).find("option:selected").attr("data-merk");
        $.post( dds_main_vars.siteurl+"/wp-content/plugins/dds-tools/modules/forms/modellen.php", { "merkid": merkid }, function( data ) {
            
            $(currentselect).parents(".dds_form").find("select[name=model]").html("");
            $(currentselect).parents(".dds_form").find("select[name=model]").append("<option></option>");
            $(currentselect).parents(".dds_form").find("select[name=model]").append(data);
            $(currentselect).parents(".dds_form").find("select[name=model]").append("<option value='andere'>Andere</option>");
          });
        



        $("select[name=model]").prop("disabled",false);

       
    });



    $(".main_level1 input[name=merk],.main_level1 select[name=merk]").on("change",function(){
       $(".main_level2 input[name=merk]").val($(this).val());
       $(this).parents("form").find(".merk_hidden").val($(this).val());
       $(".main_level2 .merk_hidden").val($(this).val());
    });
    $(".main_level1 select[name=merkmobilhome]").on("change",function(){
        $(".main_level2 input[name=merk]").val($(this).val());
        $(this).parents("form").find(".merk_hidden").val($(this).val());
        $(".main_level2 .merk_hidden").val($(this).val());
     });

    $(".main_level1 input[name=model],.main_level1 select[name=model]").on("change",function(){
        $(".main_level2 input[name=model]").val($(this).val());
        $(this).parents("form").find(".model_hidden").val($(this).val());
        $(".main_level2 .model_hidden").val($(this).val());
     });


     //excl tijd afspraken


    var excl = {};
    var ranges = [];
    
    if ( $(".excl_tijd").attr("data-excl-tijd") !== undefined){
        try {
            excl = JSON.parse($(".excl_tijd").attr("data-excl-tijd"));

            $(excl).each(function(i){


                var start_range = excl[i].t_range_start;
                var end_range = excl[i].t_range_end;
                var interval = excl[i].interval;
                var dag = excl[i].dag;
                ranges[dag] = new Array();
                ranges[dag].push(get_time_between(start_range,end_range,interval));

         

            });
            
            console.log(ranges);


        } catch(e) {
            console.error(e); 
        }
        
    }
     
    $(".dds_input_group select[name=datum]").on("select2:select",function(e){
       
        $(".dds_input_group select[name=tijd] option").each(function(){
            $(this).removeAttr("hidden");
        });
       

        var selected_dag = $(this).children("option:selected").attr("data-dag");

       
        if(!$.isEmptyObject(excl)){
        $(excl).each(function(index){

            if(selected_dag == excl[index].dag){
                
               var dag = excl[index].dag;
            
                $(".dds_input_group select[name=tijd] option").each(function(){
                    
                  
                    
                    if(ranges[dag][0].includes($(this).val())){

                        $(this).attr("hidden",true);
                        
                    }
    
    
                });
            }


        });
    }

        
       

    });
   

});