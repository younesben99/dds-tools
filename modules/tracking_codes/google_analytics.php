<?php

add_action( 'wp_head', function(){
    $digiflow_settings_options = get_option( 'digiflow_settings_option_name' );
    ?>
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=<?php
   echo($digiflow_settings_options['google_analytics_tracking_id_0']); ?>"></script>
   <script>
     window.dataLayer = window.dataLayer || [];
     function gtag(){dataLayer.push(arguments);}
     gtag('js', new Date());
   
     gtag('config', '<?php echo($digiflow_settings_options['google_analytics_tracking_id_0']); ?>');
   </script>
   
   
   <?php
   });

   add_action( 'wp_footer', function(){
    $digiflow_settings_options = get_option( 'digiflow_settings_option_name' );
    ?>
   
   <script>jQuery(document).ready(function(){
    
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
    });</script>
   
   <?php
   });
?>