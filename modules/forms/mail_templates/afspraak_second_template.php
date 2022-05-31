<?php



$chosenbanner = array("http://digiflowroot.be/images/mailbanner_1.jpg","http://digiflowroot.be/images/mailbanner_2.jpg","http://digiflowroot.be/images/mailbanner_3.jpg");

$randimg = rand(0,2);

$sp_dealer_filter_tel = str_replace(' ', '', $sp_dealer_tel);

if(!empty($sp_dealer_tel)){
    $sp_phone_a_btn = "<a href='tel:".$sp_dealer_filter_tel."' class='phonebtn'>".$sp_dealer_tel."</a>";
}


?>
<!doctype html>
<html>
<head>
<meta charset='UTF-8'>
<title><?php echo $second_subject; ?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>
<style>
    *{
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    html,body{
        background: #eeeeee;
        font-family: 'Open Sans', sans-serif, Helvetica, Arial;
    }
    img{
        max-width: 100%;
    }
    .mail_main_table td{
        padding: 10px 0px;
    }
    table{
        border-collapse: collapse;
    }

    .mail_main_table tr {
    border-bottom: 1px solid #efefef;
}
.mail_main_table tr:last-child {
    border-bottom: 0px solid #efefef;
}
    /* This is what it makes reponsive. Double check before you use it! */
    @media only screen and (max-width: 480px){
        table tr td{
            width: 100% !important;
            float: left;
        }
    }
    .topbanner{
        border-radius: 5px 5px 0 0;
    padding: 0 10%;
    text-align: left;
    height: 200px;
    background-image: url(<?php echo($chosenbanner[$randimg]); ?>) !important;
    background-position-y: center !important;
    background-size: cover !important;
    }
    a.imgawrap {
        display: inline-block  !important;
        border-radius: 10px !important;
        margin: 0 15px 10px 0px;
}
.imgwrap {
    object-fit: cover !important;
    width: 120px !important;
    height: 100px !important;
    border-radius: 5px !important;
    border: 1px solid #e4e4e4;

}
.phonebtn {
    text-align: center;
    background: #24bf56;
    color: white !important;
    width: 79%;
    padding: 13px;
    border-radius: 5px;
    border: 2px solid #11ad43;
    cursor: pointer;
    display: block;
    margin-top: 0;
    font-size: 19px;
    margin: auto;
    text-decoration:none;
}
.voordelenlist {
  list-style: none;
  font-size: 14px;
  margin: 0; 
    padding: 0; 
}
.voordelenlist li{
    margin-top:10px;
}

</style>
</head>

<body style='background: #eaeaea; font-family: Open Sans, sans-serif, Helvetica, Arial;'>

<center style='background: #eaeaea;
    padding: 25px;'> <!-- Let's Center it. just in case email client does not support margin: 0 auto -->



<!-- ** Table begins here
----------------------------------->
<!-- Set table width to fixed width for Outlook(Outlook does not support max-width) -->
<table width='100%' cellpadding='0' cellspacing='0' bgcolor='FFFFFF' style='box-shadow: 0px 1px 2px 0px #d0d0d0;border-radius: 4px;background: #ffffff; max-width: 600px !important; margin: 0 auto; background: #ffffff;'>

 


 <tr>
        <td class='topbanner' style='background: <?php echo $primary_color;?>;'>
            <h1 style='color: #ffffff;
    font-size: 17px;
    font-weight: 300;
    margin: 15px 0;
    width: 100%;'><?php
            if(!empty($second_mail_title)){
                echo $second_mail_title;
            }
            ?></h1>
        </td>
    </tr>


    <tr>
        <td>
    <div style='width:80%;margin:auto;padding-top:25px;'>
            <p style='width: 100%;line-break: anywhere;'><?php
            
            if(!empty($second_mail_main_con)){
                echo $second_mail_main_con; 
            }

           
            
            
            
            ?>
             <h3>Neem contact met ons op:</h3>

             <table class='mail_main_table' style='width: 100%;'>
             <tr><td class="nametd">Telefoonnummer</td><td><a href="tel:<?php echo($sp_dealer_tel); ?>"><?php echo($sp_dealer_tel); ?></a></td>
             <tr><td class="nametd">E-mailadres</td><td><?php echo($sp_contactmail); ?></td>
                 <tr>
        </table>
        
        
        </p>
             </div>
        </td>
    </tr>
  

   
    <tr>
    <td>


    <?php

function make_google_calendar_link($name, $begin, $end, $location, $details) {

    $begin = intval($begin);
    $end = intval($end);
	$params = array('&dates=', '/', '&details=', '&location=', '&sf=true&output=xml');
	$url = 'https://www.google.com/calendar/render?action=TEMPLATE&text=';
	$arg_list = func_get_args();
    for ($i = 0; $i < count($arg_list); $i++) {
    	$current = $arg_list[$i];
    	if(is_int($current)) {
    		$t = new DateTime('@' . $current, new DateTimeZone('Europe/Brussels'));
    		$current = $t->format('Ymd\THis');
    		unset($t);
    	}
    	else {
    		$current = urlencode($current);
    	}
    	$url .= (string) $current . $params[$i];
    }
    return $url;
}


$unix_datum = date('Y-m-d', $unix_datum);

$unix_datum = strtotime($unix_datum. " ".$tijd);

$gcl = make_google_calendar_link($pagetitle . " | Afspraak", $unix_datum,  $unix_datum, "Afspraak | ".$pagetitle, $sp_locatie);

?>
<hr>
 
<center style="margin-top:30px;margin-bottom:30px;" >

    <a href="<?php echo($gcl); ?>" target="_blank" style="border-radius: 5px;
    text-decoration: none;
    background-color: #f5f5f5;
    color: #232530;
    padding: 10px 20px;
    font-weight: bold;
    width: 200px;
    margin: 40px 10px;
    border: 1px solid #e5e5e5;"><div style="display: inline;
    vertical-align: middle;
    margin-right: 10px;">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/a5/Google_Calendar_icon_%282020%29.svg/1024px-Google_Calendar_icon_%282020%29.svg.png" height="16" width="16"/></div> Google Calendar</a>

    <a href="<?php echo("https://www.google.com/maps?q=".urlencode($sp_locatie)); ?>" target="_blank" style="border-radius: 5px;
    text-decoration: none;
    background-color: #f5f5f5;
    color: #232530;
    padding: 10px 20px;
    font-weight: bold;
    width: 200px;
    margin: 40px 10px;
    border: 1px solid #e5e5e5;"><div style="display: inline;
    vertical-align: middle;
    margin-right: 10px;">
    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/a/aa/Google_Maps_icon_%282020%29.svg/536px-Google_Maps_icon_%282020%29.svg.png" height="16" width="13"/></div> Google Maps</a>

</center>
    

    </td>
        </tr>

   
    
</table>



<!-- ** Bottom Message
----------------------------------->
<p style='text-align: center; color: #666666; font-size: 12px; margin: 10px 0;'>
    <?php echo($company); ?> | <?php echo __("Copyright","dds-tools"); ?> © <?php echo date('Y'); ?>. <?php echo __("Alle&nbsp;rechten&nbsp;voorbehouden.","dds-tools"); ?><br />.
</p>

</center>

</body>
</html>