<?php

/*
Plugin Name: Digiflow DDS Tools
Plugin URI: https://github.com/younesben99/dds-tools
Description: Tools for DDS website.
Version: 1.33
Author: Younes Benkheil
Author URI: https://digiflow.be/
License: GPL2
GitHub Plugin URI: https://github.com/younesben99/dds-tools
*/

include(__DIR__."/admin-panel/panel.php");
include(__DIR__."/generate-pages/privacypolicy/generate_privacy_policy.php");
include(__DIR__."/modules/meldingen/cookie_melding/cookie_melding.php");
include(__DIR__."/modules/tracking_codes/analytics_parser.php");
include(__DIR__."/modules/search/dds_car_search.php");

wp_enqueue_style( 'dds_car_search_module', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_car_search.css?v=23' );
    




 ?>