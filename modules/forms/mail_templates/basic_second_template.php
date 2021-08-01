<?php



$chosenbanner = array("http://digiflowroot.be/images/mailbanner_1.jpg","http://digiflowroot.be/images/mailbanner_2.jpg","http://digiflowroot.be/images/mailbanner_3.jpg");

$randimg = rand(0,2);

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
    color: white;
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
.voordelenlist li:before {
    content: '✓';
    margin-right: 5px;
    font-weight: bold;
    color: #24bf56;
}
</style>
</head>

<body style='background: #eeeeee; padding: 10px; font-family: 'Open Sans', sans-serif, Helvetica, Arial;'>

<center> <!-- Let's Center it. just in case email client does not support margin: 0 auto -->



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
            
            
            ?></p>
             </div>
        </td>
    </tr>

    <tr>
        <td>
            <div style='width:80%;margin:auto;padding-bottom:25px;'>
            <h3>Foto's:</h3>
        <?php
        if(!empty($imagelinks)){
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
    <tr style='background:#2665b8;'>
        <td>
            <h3 style='text-align:center;color:white;'>Sneller uw auto verkopen?</h3>
<h5 style='text-align:center;color:white;'>Neem telefonisch contact met ons op</h5>
        </td>
    </tr>

    <tr>
        <td>
        <div style='width:80%;margin:auto;padding-bottom:75px;'>
<table>
    <tr style='margin: 25px 0;display: block;'>
        <td style='max-width:70%;width:70%;'>
        
        <h4 style='text-align:left;'>Bel ons op voor een taxatie</h4>
        <p style='font-size:14px;'>
        Onze expert schatten de waarde van uw wagen in, en u ontvangt een bod. Dit bod is natuurlijk vrijblijvend.</p>
        <ul class='voordelenlist'>
        <li>Ontvang direct de beste prijs</li>
        <li>Aankoop van alle wagens</li>
        <li>Ontvang het bedrag via overschrijving</li>
        </ul>
        </td>
        <td style='max-width:30%;width:30%;text-align: right;'><img src="http://digiflowroot.be/images/phone-call-2.png" alt=""></td>
    </tr>
    <tr>
        <td> <a href='tel:<?php echo str_replace(' ', '', $sp_dealer_tel);;?>' class='phonebtn'><?php echo $sp_dealer_tel; ?></a></td>
   
    </tr>
</table>

</div>


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