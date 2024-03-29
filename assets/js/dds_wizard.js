
jQuery( document ).ready(function($) {

    var wlist = {};
    
    function sleep(milliseconds) {
        var start = new Date().getTime();
        for (var i = 0; i < 1e7; i++) {
          if ((new Date().getTime() - start) > milliseconds){
            break;
          }
        }
      }
    $("#ddswizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true
    });

    $("#ddswizard .dds_next").on("click",function(){
        $("#ddswizard").steps("next");
        console.log(wlist);

    });

    $("#ddswizard .dds_wizard_input").on("change",function(){
        var title = $(this).closest("section").find("h2").text();
        //console.log(title);
        var data = $(this).val();
        wlist[title] = data;
        //console.log(wlist);
        $(".wizardlist").val(JSON.stringify(wlist));
    });
    
    $("#ddswizard .singleoptiewrap").on("click",function(){
        var title = $(this).closest("section").find("h2").text();
        //console.log(title);
        var data = $(this).text();
        wlist[title] = data;
        $("#ddswizard").steps("next");
        
        //console.log(wlist);
        $(".wizardlist").val(JSON.stringify(wlist));
    });
    
    $("#ddswizard select[name='model']").on("select2:close",function(e){
        
        setTimeout(function() {
            $('.select2-container-active').removeClass('select2-container-active');
            $(':focus').blur();
            sleep(300);
            $("#ddswizard").steps("next");
        }, 1);
       
    });
    
    $("#ddswizard select").on("select2:select",function(e){
        var data = e.params.data.text;
        var title = $(this).closest("section").find("h2").text();

        var label = $(this).closest(".dds_input_group").find(".dds_form_label").text();
       
        console.log(label);

        if(label == "Merk"){
            $(".merk_hidden").val(data);
        }
        if(label == "Model"){
            $(".model_hidden").val(data);
        }
        if (wlist[title] == undefined){
            wlist[title] = {};
        }
       
        wlist[title][label] = data;
 
        //console.log(wlist);
        $("#ddswizard .wizardlist").val(JSON.stringify(wlist));
       
    })
});

