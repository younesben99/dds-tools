<?php
if(!is_admin()){
    if($_COOKIE['cookie_geaccepteerd'] !== "true") {

        add_action('wp_footer', 'cookiemeldingfooter');
        
        function cookiemeldingfooter(){
            include(__DIR__."/cookie_content.php");
        }
    }
}
?>