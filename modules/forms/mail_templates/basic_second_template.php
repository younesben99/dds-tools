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
    /* This is what it makes reponsive. Double check before you use it! */
    @media only screen and (max-width: 480px){
        table tr td{
            width: 100% !important;
            float: left;
        }
    }
</style>
</head>

<body style='background: #eeeeee; padding: 10px; font-family: 'Open Sans', sans-serif, Helvetica, Arial;'>

<center> <!-- Let's Center it. just in case email client does not support margin: 0 auto -->



<!-- ** Table begins here
----------------------------------->
<!-- Set table width to fixed width for Outlook(Outlook does not support max-width) -->
<table width='100%' cellpadding='0' cellspacing='0' bgcolor='FFFFFF' style='background: #ffffff; max-width: 600px !important; margin: 0 auto; background: #ffffff;'>
    <tr>
        <td style='padding: 5px; text-align: center; background: <?php echo $primary_color;?>;'>
            <h1 style='color: #ffffff;color: #ffffff;font-size: 21px;font-weight: 300;'><?php
            if(!empty($second_mail_title)){
                echo $second_mail_title;
            }
            ?></h1>
        </td>
    </tr>


    <tr>
        <td style='padding: 20px 50px; text-align: left;'>
    
            <p style='width: 100%;line-break: anywhere;'><?php
            
            if(!empty($second_mail_main_con)){
                echo $second_mail_main_con; 
            }
            
            
            ?></p>
                <?php

if(!empty($companytel)){

    $companylink = "tel:".str_replace(' ', '', $companytel);

   ?>
            <div style="font-size:9px;">Vragen of afspraak maken?</div>
            <p style='border-radius: 5px; -moz-border-radius: 5px; padding: 15px 20px; margin: 10px auto; background: <?php echo $hover_color;?>; display: inline-block;'>
            
<a href='<?php echo($companytellink); ?>' style='color: #fff; text-decoration: none;'>Bel <?php echo($companytel); ?></a>

</p>

    <?php
}

?>
           
        </td>
    </tr>


    <tr>
        <td>
        <?php
        if(!empty($images)){
            foreach ($images as $value) {
                ?>

                    <img src='' alt='pic1' />

                <?php
            }
        }
            
        ?>
            
        </td>
    </tr>


   

    
</table>


<!-- ** Bottom Message
----------------------------------->
<p style='text-align: center; color: #666666; font-size: 12px; margin: 10px 0;'>
    <?php echo($company); ?> | Copyright © <?php echo date('Y'); ?>. Alle&nbsp;rechten&nbsp;voorbehouden.<br />.
</p>

</center>

</body>
</html>