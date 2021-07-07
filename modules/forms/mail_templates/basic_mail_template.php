<!doctype html>
<html>
<head>
<meta charset='UTF-8'>
<title><?php echo $subject; ?></title>
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
        <td style='padding: 0px 0px 5px 0;
    text-align: center;
    background: #193450;
    border-top: 4px solid #254e79;'>
            <img src="https://digiflowroot.be/assets/dds_170_white.png" style="width: 170px;margin-top: 10px; image-rendering: auto;"  alt="Digiflow" width="170" />
        </td>
</tr>   
<tr>
        <td style='padding: 5px; text-align: center; background: #254f79;'>
            <h1 style='color: #ffffff;color: #ffffff;font-size: 21px;font-weight: 300;'><?php
            if(!empty($mail_title)){
                echo $mail_title;
            }
            ?></h1>
        </td>
    </tr>


    <tr>
        <td style='padding: 20px 50px; text-align: left;'>
    
            <p style='width: 100%;line-break: anywhere;'><?php
            
            if(!empty($mail_main_con)){
                echo $mail_main_con; 
            }
            
            
            ?></p>
                <?php

if(!empty($tel)){

    $tellink = "tel:".str_replace(' ', '', $tel);

   ?>
            <p style='border-radius: 5px; -moz-border-radius: 5px; padding: 15px 20px; margin: 10px auto; background: #254e79; display: inline-block;'>

<a href='<?php echo($tellink); ?>' style='color: #fff; text-decoration: none;'>Bel <?php echo($tel); ?></a>

</p>

    <?php
}

?>
           
        </td>
    </tr>


    <tr>
        <td>
            <div style="text-align:center;">
        <?php
        if(!empty($imagelinks)){
            foreach ($imagelinks as $value) {
                ?>

                    <a href='<?php echo($value); ?>'><img src='<?php echo($value); ?>' style='width:25%;border-radius:10px;max-width: 100%;
    height: 100px !important;
    object-fit: contain;' /></a>

                <?php
            }
        }
            
        ?>
            </div>
        </td>
    </tr>


   

    
</table>


<!-- ** Bottom Message
----------------------------------->
<p style='text-align: center; color: #666666; font-size: 12px; margin: 10px 0;'>
    Digiflow | Copyright © <?php echo date('Y'); ?>. Alle&nbsp;rechten&nbsp;voorbehouden.<br />.
</p>

</center>

</body>
</html>