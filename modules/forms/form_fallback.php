<?php



if (isset($_POST["telefoonnummer"])) {


    

    include(__DIR__."/../../../../../wp-load.php");


    dds_form_db_log($_POST,$_POST["formtype"]);
    
    $dds_settings_options = get_option( 'dds_settings_option_name' );

    $sp_contactmail = $dds_settings_options['dealer_contact_mail'];

    $email = $_POST["emailadres"];
    $merk = $_POST["merk"];
    $model = $_POST["model"];
    $dds_form_type = $_POST["formtype"];


    switch ($dds_form_type) {
        case 'aankoop':
        $message .= "<h2>De volgende wagen wordt u aangeboden: ".$merk." ". $model ."</h2>" ;
        $subject = "De volgende wagen wordt u aangeboden: ".$merk." ". $model;
            break;
        case 'testrit':
        $message .= "<h2>Testrit geboekt voor de wagen: ".$merk." ". $model ."</h2>" ;
        $subject = "Testrit geboekt voor de wagen: ".$merk." ". $model;
            break;
        case 'beschikbaarheid':
        $message .= "<h2>Contactbericht voor de volgende wagen: ".$merk." ". $model ."</h2>" ;
        $subject = "Contactbericht voor de volgende wagen: ".$merk." ". $model;
            break;    
        default:
        $message .= "<h2>Contactbericht</h2>";
        $subject = "Contactbericht";
            break;
    }

   

    foreach ($_POST as $key => $value) {
        
      
        
        if(!empty($value)){
            if($key !== "formtype")
            {
                $message .= "<b>". $key . "</b> : " . $value . "<br>";
            }
            
        }
        
        
    }
    
    $to = $sp_contactmail;


    $headers = 'From: '. $email . "\r\n" .
        'Reply-To: ' . $email . "\r\n" .
        'Content-Type: text/html' . "\r\n" .
        'charset=UTF-8'."\r\n";



    $sent = wp_mail($to, $subject, $message, $headers);
        if($sent) {
            header("Location: /bedankt/");
    }
        else  {
            //echo(json_encode("er is een probleem, probeer later opnieuw"));
    }


    

}

?>