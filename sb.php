<?php

include(__DIR__."/../../../wp-load.php");

$car = dds_car(797);



foreach($car as $key => $value){
    echo $key."<br>";
}


