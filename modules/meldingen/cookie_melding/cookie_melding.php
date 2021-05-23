<?php
if(!is_admin()){
        add_action('wp_footer', 'cookiemeldingfooter');
        function cookiemeldingfooter(){
            include(__DIR__."/cookie_content.php");
        }
    
}
?>