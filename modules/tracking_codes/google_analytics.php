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

   wp_enqueue_script(
    'analytics_tracker', 
    get_site_url() . '/wp-content/plugins/dds-tools/assets/js/analytics_tracker.js?v=1.1', 
    array( 'jquery' ), 
    false, 
    true 
);
  
?>