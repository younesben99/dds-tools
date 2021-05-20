<?php
if(!is_admin()){
    if($_COOKIE['cookie_geaccepteerd'] !== "true") {
        include(__DIR__."/cookie_content.php");
    }
}
?>