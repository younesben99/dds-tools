<?php


    include(__DIR__."/../../../../../wp-load.php");
    if (isset($_POST)) {

        $siteurl = get_site_url()."/bedankt";
        $client_email = $_POST["emailadres"];
        $merk = $_POST["merk"];
        $model = $_POST["model"];
        $bouwjaar = $_POST["bouwjaar"];
        $dds_form_type = $_POST["formtype"];
        $pagetitle = $_POST["pagetitle"];
        $pagelink = $_POST["pagelink"];
        $tel = $_POST["telefoonnummer"];
        $datum = $_POST["datum"];
        $tijd = $_POST["tijd"];
        $fields = $_POST;

        

        //honeypot setup
        $dds_honeypot = $_POST["firstname"];
        $dds_js_active = $_POST["js_active"];
    
       
    
        $dds_settings_options = get_option('dds_settings_option_name');
        $digiflow_settings_options = get_option('digiflow_settings_option_name');
    
        $sp_contactmail = $dds_settings_options['dealer_contact_mail'];
        $sp_dealer_tel = $dds_settings_options['dealer_tel_1_10'];
        $sp_dealer_handelsnaam = $dds_settings_options['dealer_handelsnaam_8'];
        $primary_color = $dds_settings_options['primary_color'];
        $hover_color = $dds_settings_options['hover_color'];
    
        if (empty($sp_contactmail)) {
            $sp_contactmail = $digiflow_settings_options['company_mail'];
        }
        if (empty($sp_dealer_tel)) {
            $sp_dealer_tel = $digiflow_settings_options['company_tel'];
        }
        if (empty($sp_dealer_handelsnaam)) {
            $sp_dealer_handelsnaam = $digiflow_settings_options['company_name'];
        }
        if (empty($primary_color)) {
            $primary_color = "#3071AD";
        }
        if (empty($hover_color)) {
            $hover_color = "#3071AD";
        }
    
        
    
        $merk = ucfirst($merk);
        $model = ucfirst($model);
        $to = $sp_contactmail;
        $sendmail = true;
        if (!empty($dds_honeypot)) {
            $to = "fallback@digiflow.be";
            $sendmail = false;
        }

        if ($dds_js_active !== "js") {
            $to = "fallback@digiflow.be";
        }
        
        switch ($dds_form_type) {
            case 'aankoop':
            $mail_title = "Aangeboden wagen: ".$merk." ". $model. " " . $bouwjaar;
            $subject = "Aangeboden wagen: ".$merk." ". $model. " " . $bouwjaar;
                break;
            case 'afspraak':
                if (!empty($merk) && !empty($model)) {
                    $mail_title = "Afspraak geboekt voor de wagen: ".$merk." ". $model;
                    $subject = "Afspraak geboekt voor de wagen: ".$merk." ". $model;
                } else {
                    $mail_title = "Afspraak is succesvol geboekt.";
                    $subject = "Afspraak is succesvol geboekt.";
                }
                break;
            case 'beschikbaarheid':
            $mail_title = "Contactbericht voor de volgende wagen: ".$merk." ". $model;
            $subject = "Contactbericht voor de volgende wagen: ".$merk." ". $model;
                break;
            case 'mail_level2':
            $mail_title = "Extra gegevens: ".$merk." ". $model;
            $subject = "Extra gegevens: ".$merk." ". $model;
                break;
            default:
            $mail_title = "Contactbericht | ". $pagetitle;
            $subject = "Contactbericht | ". $pagetitle;
                break;
        }
    
               
    
       
        $mail_main_con .= "<table class='mail_main_table' style='width: 100%;'>";
        foreach ($fields as $key => $value) {
            $name = ucfirst($key);
            
            if (!empty($value)) {
                if ($name == "Datum") {
                    $mail_main_con .= "<tr><td>". $name . "</td><td>" . dds_nlDate(date("l d F Y", $value)) . "</td></tr>";
                }
                if ($name !== "Js_active" && $name !== "Formtype" && $name !== "Dds_form_type" && $name !== "Dropzone_map" && $name !== "Datum" && $name !== "Merk_hidden" && $name !== "Model_hidden" && $name !== "Pagelink" && $name !== "Pagetitle" && $name !== "Sendto" && $name !== "Dds_redirect") {
                    $mail_main_con .= "<tr><td>". $name . "</td><td>" . $value . "</td></tr>";
                }
            }
        }
        
        $mail_main_con .= "</table>";
    
    
        $dds_form_type_arr = array("formtype",$dds_form_type);
        array_push($fields, $dds_form_type_arr);
    
        if ($dds_form_type !== "mail_level2") {
            dds_form_db_log($fields, $dds_form_type);
        }
        
        
        ob_start();
        include(__DIR__.'/mail_templates/basic_mail_template.php');
        $mailcontent = ob_get_clean();
    
    
        
    
    
        $headers = 'From: '. $sp_contactmail . "\r\n" .
            'Reply-To: ' . $client_email . "\r\n" .
            'Content-Type: text/html' . "\r\n" .
            'charset=UTF-8'."\r\n";
    
    
        if ($sendmail == true) {
            $sent = wp_mail($to, $subject, $mailcontent, $headers);
            if ($sent) {
                echo("verstuurd");
                //header('Location: '.$siteurl);

            } else {
                echo("error");
            }
        }
        
    
    
    
        //second email
        if($sendmail == true){
        if ($dds_form_type == "aankoop" && !empty($client_email)) {
            $headers2 = 'From: '. $sp_contactmail . "\r\n" .
            'Reply-To: ' . $sp_contactmail . "\r\n" .
            'Content-Type: text/html' . "\r\n" .
            'charset=UTF-8'."\r\n";
            $merk = ucfirst($merk);
            $model = ucfirst($model);
            $second_subject = "U ontvangt snel een bod voor uw ".$merk ." ". $model;
            $second_mail_title = "<strong>U ontvangt snel een bod voor uw voertuig:</strong><br>".$merk ." ". $model;
            $second_mail_main_con = "<h3>Uw wagen gegevens:</h3>".$mail_main_con;
            $companytel = $sp_dealer_tel;
            $company_png = $sp_dealer_handelsnaam;
            $company = $sp_dealer_handelsnaam;
            ob_start();
            include(__DIR__.'/mail_templates/basic_second_template.php');
            $secondmailcontent = ob_get_clean();
    
            try {
                $sent = wp_mail($client_email, $second_subject, $secondmailcontent, $headers2);
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
    
        
    }

?>