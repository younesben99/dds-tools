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
 
    a.imgawrap {
        display: inline-block  !important;
        border-radius: 10px !important;
        margin: 0 15px 10px 0px;
}
.imgwrap {
    object-fit: cover !important;
    width: 125px !important;
    height: 100px !important;
    border-radius: 5px !important;
    border: 1px solid #e4e4e4;

}

.mail_main_table td{
        padding: 10px 0px;
        text-align:right;
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
.nametd{
    color:#6a6a6a;
    width: 50%;
    text-align:left !important;
}
@media only screen and (max-width: 650px) {
    .nametd{
    width: 100%;
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
            <p style='border-radius: 5px; -moz-border-radius: 5px; padding: 15px 20px; margin: 10px auto; background: #254e79; display: inline-block;    box-shadow: 0 1px 3px 0 #00000080;'>

<a href='<?php echo($tellink); ?>' style='color: #fff; text-decoration: none;font-weight:500;'>Bel <?php echo($tel); ?></a>


</p>

    <?php
}


if($show_as_search && !empty($merk) && !empty($model) && !empty($brandstof)){
?>
<br>
<p style='border-radius: 5px; -moz-border-radius: 5px; padding: 15px 20px; margin: 10px auto; background: #f5f202; display: inline-block;    box-shadow: 0 1px 3px 0 #00000080;'>

<a href='<?php echo($as_url_link); ?>' style='color: #333333; text-decoration: none;font-weight:500;'>Zoeken op Autoscout</a>


</p>

<?php
}


?>
        </td>
    </tr>


    <tr>
        <td>
            <div style='width:80%;margin:auto;padding-bottom:50px;'>
          
        <?php
        if(!empty($imagelinks)){
            ?>
            <h3>Foto's:</h3>
                      <?php
            foreach ($imagelinks as $value) {
                ?>

                    <a href='<?php echo($value); ?>' class='imgawrap'><img src='<?php echo($value); ?>' class='imgwrap' /></a>

                <?php
            }
        }
            
        ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div style="margin: auto;
    display: block;
    text-align: center;
    width: 100%;
    padding-bottom: 25px;
    font-size: 13px;">
            <small style="color:#254e79"><em>Verstuurd vanuit: <?php echo($pagelink_dds); ?></em></small>
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