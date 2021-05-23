<?php
if(!is_admin()){
    if(!isset($_COOKIE['cookie_geaccepteerd'])) {

        add_action('wp_footer', 'cookiemeldingfooter');
        
        function cookiemeldingfooter(){
            $show_consent = true;
            include(__DIR__."/cookie_content.php");
        }
    }
}
?>