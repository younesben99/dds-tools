<?php

add_action('wp_head', function() {
    if (!is_user_logged_in()) {
        $digiflow_settings_options = get_option('digiflow_settings_option_name');
        ?>
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo esc_attr($digiflow_settings_options['google_analytics_tracking_id_0']); ?>"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() {
                dataLayer.push(arguments);
            }
            gtag('js', new Date());

            gtag('config', '<?php echo esc_js($digiflow_settings_options['google_analytics_tracking_id_0']); ?>');

            gtag('consent', 'update', {
                'ad_user_data': 'granted',
                'ad_personalization': 'granted',
                'ad_storage': 'granted',
                'analytics_storage': 'granted'
            });
        </script>
        <?php
    }
});

add_action('wp_enqueue_scripts', function() {
    if (!is_user_logged_in()) {
        wp_enqueue_script(
            'analytics_tracker',
            plugins_url('dds-tools/assets/js/analytics_tracker.js?v=1.6'),
            array('jquery'),
            null,
            true
        );
    }
});
?>
