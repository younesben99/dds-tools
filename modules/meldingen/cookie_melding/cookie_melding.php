<?php
if(!is_admin()){
    if(!isset($_COOKIE['cookie_geaccepteerd'])) {
        include(__DIR__."/cookie_content.php");
    }
}


?>