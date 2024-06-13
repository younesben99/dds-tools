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
    td.thumbsup_td {
    text-align: center !important;
    margin: 20px 18px;
    padding: 35px 50px 40px;
    background: #fefefe;
    border: 1px solid #e8e8e8;
    border-right: 0px;
    border-left: 0;
}
    a.imgawrap {
        display: inline  !important;
        border-radius: 10px !important;
  
}
.imgwrap {
    object-fit: cover !important;
    width: 44% !important;
    max-height: 300px !important;
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
/* Basisstijl voor knoppen */
.btn {
    padding: 10px 38px;
    text-align: left;
    text-decoration: none;
    border-radius: 40px;
    display: inline-block;
    font-size: 16px;
    font-weight: 400;
    cursor: pointer;
    border: none;
    margin-right: 10px;
    transition: all 0.2s ease-in-out;
    width: 300px;
    max-width: 100%;

}

/* Specifieke stijl voor "Markeer als Topkeuze" */
.topkeuze {
    background-color: #29BB9C;
    color: #ffffff;
}

.topkeuze:hover {
    background-color: #1a7d68;
}

/* Specifieke stijl voor "Markeer als Interessant" */
.interessant {
    background-color:#2985bb;
    color: #ffffff;
}
.nietinteressant {
    background-color:#BB5C7A;
    color: #ffffff;
}

.interessant:hover {
    background-color: #0669A4;
}
.nietinteressant:hover {
    background-color:#BB345F;
    color: #ffffff;
}
.btn img {
    vertical-align: middle; 
    float: left;

    margin-right: 20px;
}

.btn span {
    color:white;
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
    <td style='background: #254f79;'>
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <!-- Mail Title with 70% Width -->
                <td width="70%" style='    width: 70%;color: #ffffff; font-size: 15px; font-weight: 300; padding: 15px; vertical-align: middle;'>
                    <?php if (!empty($mail_title)) { echo $mail_title; } ?>
                </td>
                
                <!-- Zoeken op Autoscout Button with 30% Width -->
                <?php if ($show_as_search && !empty($merk) && !empty($model) && !empty($brandstof)) { ?>
                    <td width="30%" style=' padding:10px;width: 30%;text-align: center; vertical-align: middle;'>
                        <a href='<?php echo $as_url_link; ?>' style='color: #ffffff;
    text-decoration: none;
    font-weight: 500;
    background: #0d1228db;
    padding: 5px 10px;
    border-radius: 5px;
    border: 1px solid;
    font-size: 12Px;'>Zoeken op Autoscout</a>
                    </td>
                <?php } ?>
            </tr>
        </table>
    </td>
</tr>




<tr>
    <td align="center">
        <div  style='margin: 0px;
    width: 286px;
    border-radius: 0 0 5px 5px;
    padding: 5px;
    text-align: center;
    background: #f8f8f8;
    border: 1px solid #ededed;
    border-top: 0px;
    font-size: 13px;font-weight: 400;'>
    Afkomstig vanuit <?php echo $source; ?>
</div>
    </td>
</tr>
    <tr>
        <td style='padding: 20px 50px; text-align: center;'>
    
            <p style='width: 100%;line-break: anywhere;'><?php
            
            if(!empty($mail_main_con)){
                echo $mail_main_con; 
            }
            
            
            ?></p>
                <?php

if(!empty($tel)){

    $tellink = "tel:".str_replace(' ', '', $tel);

   ?>
            <p style='border-radius: 50px; -moz-border-radius: 50px; padding: 10px 30px; margin: 10px auto; background: #254e79; display: inline-block;    box-shadow: 0 1px 3px 0 #00000080;'>

<a href='<?php echo($tellink); ?>' style='color: #fff; text-decoration: none;font-weight:500;'>Bel <?php echo($tel); ?></a>


</p>

    <?php
}

if (!empty($gclid)) {
                      
    echo "<tr>
    <td class='thumbsup_td'>
        <h3>Optimaliseer uw resultaten! Beoordeel de Mail</h3>
        <p style='font-size:14px; margin-bottom: 30px;'>Door te kiezen voor 'Markeer als Topkeuze' of 'Markeer als Interessant', zorgt u ervoor dat wij u in de toekomst meer relevante en waardevolle e-mails kunnen sturen.</p>
        
        <table cellspacing='0' cellpadding='0' style='width: 100%;border-collapse: collapse;'>
        <tr>
            <td style='padding: 10px; text-align: center; vertical-align: middle;'>
                <a href='".$adwords_push_url."?version=".$gclid."&campaign=".$domain."&type=topkeuze' class='btn topkeuze'>
                    <img src='https://digiflowroot.be/static/images/icons/thumb-up-white.png' height='25' width='25' style='vertical-align: middle;'/>
                    <span>Markeer als Topkeuze</span>              </a>
            </td>
        </tr>
        <tr>
            <td style='padding: 10px; text-align: center; vertical-align: middle;'>
                <a href='".$adwords_push_url."?version=".$gclid."&campaign=".$domain."&type=interessant' class='btn interessant'>
                    <img src='https://digiflowroot.be/static/images/icons/star-ads.png' height='25' width='25' style='vertical-align: middle;'/>
                    <span>Markeer als Interessant</span>
                </a>
            </td>
        </tr>
        <tr>
        <td style='padding: 10px; text-align: center; vertical-align: middle;'>
            <a href='".$full_plugin_url_negative."?version=".$gclid."&campaign=".$domain."&type=negative&makemodel=".$merk.":".$model."' class='btn nietinteressant'>
                <img src='https://digiflowroot.be/static/images/icons/thumbs_down_white.png' height='25' width='25' style='vertical-align: middle;'/>
                <span>Niet Interessant</span>      </a>
        </td>
    </tr>
    </table>
    

    </td>
</tr>";

    
}



?>
        </td>
    </tr>


    <tr>
        <td>
            <div style='width: 80%;
    margin: auto;
    padding-bottom: 50px;
    text-align: center;'>
          
        <?php
  
        if(!empty($imagelinks)){
            ?>
  
            <a style="    width: 200px;
    background: #254f79;
    color: white;
    text-decoration: none;
    text-align: center;
    padding: 10px 20px 15px;
    border-radius: 4px;
    font-size: 20px;
    vertical-align: middle;
    line-height: 1.5;" href="<?php echo get_site_url() . "/wp-content/plugins/dds-tools/modules/forms/dds_dropzone_slideshow.php?query=".$dropzone_map; ?>" target="_blank"><img style="width: 25px;
    height: 25px;
    vertical-align: middle;
    margin-right: 10px;" src="<?php echo get_site_url() . "/wp-content/plugins/dds-tools/modules/forms/assets/gallery_dds.png"; ?>" /> Bekijk foto's</a>

            <?php
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
    font-size: 15px;">
            <small style="color:#254e79"><em><a href="<?php echo($pagelink_dds); ?>">Verstuurd vanuit: <?php echo($pagelink_dds); ?></a></em></small>
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