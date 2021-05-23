<?php
add_action( 'wp_head', function(){
    $digiflow_settings_options = get_option( 'digiflow_settings_option_name' );
    ?>
   <!-- Hotjar Tracking Code for waaslandcars.be -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:<?php echo($digiflow_settings_options['hotjar_tracking_id_4']); ?>,hjsv:6};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'https://static.hotjar.com/c/hotjar-','.js?sv=');
</script>
    <?php
});

?>