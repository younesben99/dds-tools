<?php

$digiflow_settings_options = get_option( 'digiflow_settings_option_name' ); // Array of All Options
$ga_tracking_id = $digiflow_settings_options['google_analytics_tracking_id_0']; // Google analytics tracking id
$fb_pixel_tracking_id = $digiflow_settings_options['facebook_pixel_tracking_id_1']; // Facebook pixel tracking id
$bing_tracking_id = $digiflow_settings_options['bing_tracking_id_2']; // Bing tracking id
$opimize_tracking_id = $digiflow_settings_options['optimize_tracking_id_3']; // Optimize tracking id
$hotjar_tracking_id = $digiflow_settings_options['hotjar_tracking_id_4']; // Hotjar tracking id
$fb_chat_page_id = $digiflow_settings_options['fb_chat_id_5']; // Fb chat id
$fb_chat_color = $digiflow_settings_options['fb_chat_color_6']; // Fb chat color

if(!empty($ga_tracking_id)){
    include(__DIR__."/google_analytics.php");
}
if(!empty($fb_pixel_tracking_id)){
    include(__DIR__."/facebook_tracking.php");
}
if(!empty($bing_tracking_id)){
    include(__DIR__."/bing_analytics.php");
}
if(!empty($opimize_tracking_id)){
    include(__DIR__."/google_optimizer_tracking.php");
}
if(!empty($hotjar_tracking_id)){
    include(__DIR__."/hotjar_tracking.php");
}
if(!empty($fb_chat_page_id)){
    include(__DIR__."/facebook_chat.php");
}






?>