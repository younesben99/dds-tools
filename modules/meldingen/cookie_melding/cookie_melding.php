<?php

$digiflow_settings_options = get_option( 'digiflow_settings_option_name' );

if (isset($digiflow_settings_options['cookienotice_toggle'])) {
    $cookienotice_toggle = $digiflow_settings_options['cookienotice_toggle'];

    if ($cookienotice_toggle == "cookieactief" && !is_admin()) {
        add_action('wp_footer', 'cookiemeldingfooter');

        function cookiemeldingfooter() {
            include(__DIR__ . "/cookie_content.php");
        }
    }
}



?>