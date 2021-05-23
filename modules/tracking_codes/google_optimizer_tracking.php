<?php
add_action( 'wp_head', function(){
    $digiflow_settings_options = get_option( 'digiflow_settings_option_name' );
?>

<script src="https://www.googleoptimize.com/optimize.js?id=<?php echo($digiflow_settings_options['optimize_tracking_id_3']); ?>"></script>

<?php
});
?>