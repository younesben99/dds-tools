
jQuery( document ).ready(function($) {
    function sleep(delay) {
        var start = new Date().getTime();
        while (new Date().getTime() < start + delay);
    }
    $("#ddswizard").steps({
        headerTag: "h3",
        bodyTag: "section",
        transitionEffect: "slideLeft",
        autoFocus: true
    });

    $(".singleoptiewrap").on("click",function(){
        $("#ddswizard").steps("next");
    });
    $("select[name='model']").on("select2:close",function(){

    
        $("#ddswizard").steps("next");

       
    })
});

