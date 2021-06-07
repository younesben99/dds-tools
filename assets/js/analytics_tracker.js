jQuery(document).ready(function(){
    jQuery('a,button,input[type=submit]').on('click',function(){
   
    var eventaction = 'None';
    var eventlabel = 'None';
    var eventform = '';
    if(jQuery(this).attr('href')){
    if(jQuery(this).attr('href') !== ''){
    eventaction = jQuery(this).attr('href');
    }
    }
    else{
    if(jQuery(this).parents('form').length == 1 ){
        if(jQuery(this).parents('form').attr('name')){
            eventaction = 'Form: ' + jQuery(this).parents('form').attr('name');
            eventform = jQuery(this).parents('form').attr('name') + ' > ';
        }
        else{
            eventaction = 'Form: ' + jQuery(this).parents('form').attr('action');
            eventform = jQuery(this).parents('form').attr('action') + ' > ';
        }
    }
    }
    
    if(jQuery(this).text() !== ''){
    eventlabel = jQuery(this).text().trim();
    }
    else{
    eventlabel = jQuery(this).val().trim();
    }
    
    console.log('eventlabel: ' +  eventform + eventlabel);
    console.log('category: ' + window.location.href);
    console.log('eventaction: ' + eventaction);
  gtag('event', eventform + eventlabel, {
          'event_category': window.location.href,
          'event_label': eventaction
    });
    
    });
    });