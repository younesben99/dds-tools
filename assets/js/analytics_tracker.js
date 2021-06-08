jQuery(document).ready(function(){
    var eventform = '';

    jQuery('a,button,input[type=submit]').on('click',function(){
   
    var eventlabel = 'None';
    var eventaction = 'None';
    
    if(jQuery(this).attr('href')){
    if(jQuery(this).attr('href') !== ''){
    eventlabel = jQuery(this).attr('href');
    }
    }
    else{
    if(jQuery(this).parents('form').length == 1 ){
        if(jQuery(this).parents('form').attr('name')){
            eventlabel = 'ClickForm: ' + jQuery(this).parents('form').attr('name');
            eventform = jQuery(this).parents('form').attr('name');
        }
        else{
            eventlabel = 'ClickForm: ' + jQuery(this).parents('form').attr('action');
            eventform = jQuery(this).parents('form').attr('action');
        }
    }
    }
    
    if(jQuery(this).text() !== ''){
    eventaction = jQuery(this).text().trim();
    }
    else{
    eventaction = jQuery(this).val().trim();
    }
    
    console.log('eventaction: ' +  eventform + ' > ' + eventaction);
    console.log('category: ' + window.location.href);
    console.log('eventlabel: ' + eventlabel);
  gtag('event', eventform + ' > ' + eventaction, {
          'event_category': window.location.href,
          'event_label': eventlabel
    });
    
    });

    document.addEventListener( 'wpcf7submit', function( event ) {
        console.log("Conversie! CF7");
        gtag('event', "Formulier verstuurd", {
            'event_category': window.location.href,
            'event_label': "Form: Contactform7"
      });
      }, false );

    jQuery( document ).on('submit_success', function(){

        if(eventform == "" || eventform == null){
            eventform = "Onbekend formulier";
        }
        else{
            console.log("Conversie! " + eventform);
            gtag('event', "Formulier verstuurd", {
                'event_category': window.location.href,
                'event_label': "Form: " + eventform,
          });
        }
		
	});


    });