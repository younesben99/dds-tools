<?php


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $_POST['url']) {



        if (isset($_POST["fields"])) {
            $fields_arr = json_decode($_POST["fields"], true);

            $fields = array();
            foreach ($fields_arr as $key => $value) {
                foreach ($value as $key => $value) {
                    $fields[$key] = $value;
                }
            }

          


            $as_url = array();
            $dds_form_type = $_POST["formtype"];


            $tel = $merk = $model = $client_email = $bouwjaar = $brandstof = $pagetitle = $pagelink_dds = $sendto = $kilometerstand = '';

            if (!empty($fields["telefoonnummer"])) $tel = $fields["telefoonnummer"];
            if (!empty($fields["merk"])) $merk = $fields["merk"];
            if (!empty($fields["model"])) $model = $fields["model"];
            if (empty($merk)) $merk = $fields["merk_hidden"];
            if (empty($model)) $model = $fields["model_hidden"];
            if (!empty($fields["emailadres"])) $client_email = $fields["emailadres"];
            if (!empty($fields["bouwjaar"])) $bouwjaar = $fields["bouwjaar"];
            if (!empty($fields["brandstof"])) $brandstof = $fields["brandstof"];
            if (!empty($fields["kilometerstand"])) $kilometerstand = $fields["kilometerstand"];
            if (!empty($fields["pagetitle"])) $pagetitle = $fields["pagetitle"];
            if (!empty($fields["pagelink"])) $pagelink_dds = $fields["pagelink"];
            if (!empty($fields["sendto"])) $sendto = $fields["sendto"];
            if (!empty($fields["formtype"])) $dds_form_type = $fields["formtype"];
            if (!empty($fields["bodhlist"])) $bodhlist = $fields["bodhlist"];
            if (!empty($fields["diensten"])) $dienst = $fields["diensten"];
            if (!empty($fields["source"])) $source = $fields["source"];
            if (!empty($fields["gclid"])) $gclid = $fields["gclid"];
            if (!empty($fields["domain"])) $domain = $fields["domain"];
            if(!empty($fields["merkmobilhome"])){
                $merkmobilhome = $fields["merkmobilhome"];
                $merk = $fields["merkmobilhome"];
                $model = $fields["model"];
            }
            else{
                $merkmobilhome = "";
            }


            include(__DIR__ . "/../../../../../wp-load.php");


            $plugin_url = plugins_url('dds-tools');

            $adwords_push_url = "https://digiflowroot.be/form-adwords-data.php";
            $full_plugin_url_negative = $plugin_url . "/modules/forms/assets/form-negative-data.php";
            $as_url_params = array(
                "fregfrom" => $bouwjaar,
                "sort" => "price",
                "desc" => "0",
                "cy" => "B",
                "atype" => "C",
                "powertype" => "kw"
            );


          
            if(!empty($kilometerstand) && is_numeric($kilometerstand)){
                $as_url_params["kmto"] = $kilometerstand + 25000;
            }
           
            

            $as_url_params = http_build_query($as_url_params);

            $as_url_link = "https://www.autoscout24.be/nl/lst/" . slugify($merk) . "/" . slugify($model) . "/ft_" . slugify($brandstof) . "?" . $as_url_params;

            //https://www.autoscout24.be/nl/lst/audi/a3/ft_benzine?fregfrom=2011&kmto=120000&sort=price&desc=0&cy=B&atype=C&powertype=kw
            //https://www.autoscout24.be/nl/lst/audi/a3/ft_benzine?fregfrom=2011&kmfrom=5000&kmto=120000&sort=price&desc=0&cy=B&atype=C&ustate=N%2CU&fuel=B&powertype=kw&search_id=23p0gcdhbif

            $merk = ucfirst($merk);
            $model = ucfirst($model);


            $imagelinks = array();
            if (!empty($_POST['dropzone_map'])) {
                $imagedir = __DIR__ . "/../../../../uploads/dds_dropzone/" . $_POST['dropzone_map'] . "/";
                if (file_exists($imagedir)) {
                    try {
                        $current_image_map = scandir($imagedir);


                        foreach ($current_image_map as $value) {
                            if (strlen($value) > 4) {
                                $link = get_site_url() . "/wp-content/uploads/dds_dropzone/" . $_POST['dropzone_map'] . "/" . $value;
                                array_push($imagelinks, $link);
                            }
                        }
                        //var_dump($imagelinks);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }


            $dds_settings_options = get_option('dds_settings_option_name');
            $digiflow_settings_options = get_option('digiflow_settings_option_name');

            $sp_contactmail = $dds_settings_options['dealer_contact_mail'];
            $sp_dealer_tel = $dds_settings_options['dealer_tel_1_10'];
            $sp_dealer_handelsnaam = $dds_settings_options['dealer_handelsnaam_8'];
            $primary_color = $dds_settings_options['primary_color'];
            $hover_color = $dds_settings_options['hover_color'];
            $sp_locatie = $dds_settings_options['dealer_city_9'];
            $sp_locatielink = $dds_settings_options['sp_locatie_link'];

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

            switch ($dds_form_type) {
                case 'aankoop':
                    if(empty($merkmobilhome)){
                        $mail_title = "Aangeboden wagen: " . $merk . " " . $model . " " . $bouwjaar;
                        $subject = "Aangeboden wagen: " . $merk . " " . $model . " " . $bouwjaar;
                        $show_as_search = true;
                    }
                    if(!empty($merkmobilhome)){
                        $mail_title = "Aangeboden Mobilhome: " . $merk . " " . $model . " " . $bouwjaar;
                        $subject = "Aangeboden Mobilhome: " . $merk . " " . $model . " " . $bouwjaar;
                        $show_as_search = false;
                    }
                    
                    break;
                case 'afspraak':
                    if (!empty($merk) && !empty($model)) {
                        $mail_title = "Afspraak geboekt voor de wagen: " . $merk . " " . $model;
                        $subject = "Afspraak geboekt voor de wagen: " . $merk . " " . $model;
                    } else {
                        $mail_title = $pagetitle . " | Afspraak is succesvol geboekt.";
                        $subject = $pagetitle . " | Afspraak is succesvol geboekt.";
                    }
                    break;
                case 'beschikbaarheid':
                    $mail_title = "Contactbericht: " . $merk . " " . $model;
                    $subject = "Contactbericht: " . $merk . " " . $model;
                    break;
                case 'mail_level2':
                    $mail_title = "Extra gegevens: " . $merk . " " . $model;
                    $subject = "Extra gegevens: " . $merk . " " . $model;
                    break;
                case 'offerte':
                        $mail_title = "Offerte ontvangen voor: " . $dienst;
                        $subject = "Offerte ontvangen voor: " . $dienst;
                        break;    
                case 'bodh':
                    if(empty($merk)){
                        $mail_title = "Blijf op de hoogte: " . $client_email;
                        $subject = "Blijf op de hoogte:  " . $client_email;
                    }
                    else{
                        $mail_title = "Blijf op de hoogte: " . $merk. " ".$model;
                        $subject = "Blijf op de hoogte: " . $merk. " ".$model;
                    }
                    break;
                default:
                    $mail_title = "Contactbericht | " . $pagetitle;
                    $subject = "Contactbericht | " . $pagetitle;
                    break;
            }





            $mail_main_con .= "<table class='mail_main_table' style='width: 100%;'>";
            foreach ($fields as $key => $value) {

                $name = ucfirst($key);
                $value = $value;

                if (!empty($value)) {
                    if ($name == "Datum") {
                        $unix_datum = intval($value);
                        $mail_main_con .= "<tr><td class='nametd'>Locatie</td><td><b><a href='" . $sp_locatielink . "'>" . $sp_locatie . "</a></b></td></tr>";
                        $mail_main_con .= "<tr><td class='nametd'>" . $name . "</td><td><b>" . dds_nlDate(date("l d F Y", $value)) . "</b></td></tr>";
                    }
                    if ($name == "Wizardlist") {

                        $wizard_json = json_decode($value, true);


                        foreach ($wizard_json as $key => $value) {
                            if (is_array($value)) {
                                $value = implode(" ", $value);

                              

                                $mail_main_con .= "<tr><td class='nametd'>" . $key . "</td><td><b>" . $value . "</b></td></tr>";
                            } else {
                                $mail_main_con .= "<tr><td class='nametd'>" . $key . "</td><td><b>" . $value . "</b></td></tr>";
                            }
                        }
                    }
                    if ($name !== "Bodhlist" && $name !== "Domain" && $name !== "Source" && $name !== "Wizardlist" && $name !== "Js_active" && $name !== "Formtype" && $name !== "Dropzone_map" && $name !== "Datum" && $name !== "Merk_hidden" && $name !== "Model_hidden" && $name !== "Pagelink" && $name !== "Pagetitle" && $name !== "Sendto" && $name !== "Dds_redirect" && $name !== "Gclid") {
                        
                          switch ($name) {
                                    case 'Merk':
                                       $name = __("Merk","dds-tools");
                                        break;
                                     case 'Merkmobilhome':
                                       $name = __("Merk","dds-tools");
                                        break;
                                    case 'Model':
                                        $name = __("Model","dds-tools");
                                        break;
                                    case 'Brandstof':
                                        $name = __("Brandstof","dds-tools");
                                        break;
                                    case 'Bouwjaar':
                                        $name = __("Bouwjaar","dds-tools");
                                        break;
                                    case 'Kilometerstand':
                                        $name = __("Kilometerstand","dds-tools");
                                        break;
                                    case 'Telefoonnummer':
                                        $name = __("Telefoonnummer","dds-tools");
                                        break;
                                    case 'Emailadres':
                                        $name = __("Emailadres","dds-tools");
                                        break;
                                    case 'Merk & Model':
                                        $name = __("Merk & Model","dds-tools");
                                        break;
                        }

                        $mail_main_con .= "<tr><td class='nametd'>" . $name . "</td><td><b>" . $value . "</b></td></tr>";
                    }
                    if ($name == "Bodhlist") {

                        $bodhlist = json_decode($bodhlist, true);
                      
                       
                        foreach($bodhlist as $key => $value){

                            if(!is_array($value)){
                                $mail_main_con .= "<tr><td class='nametd'>Geslecteerde Filter: " . ucfirst($key) . "</td><td><b>" . $value . "</b></td></tr>";
                            }
                            else{
                                
                                $mail_main_con .= "<tr><td class='nametd'>Geslecteerde Filter: " . ucfirst($key) . "</td><td><b>";
                            
                                $mail_main_con .= implode(" | ",preg_replace("/[^A-Za-z0-9]/", "",$value));
                                
                                $mail_main_con .= "</b></td></tr>";
                            }



                        }
                        
                    }
                   
                }
            }

    


            $mail_main_con .= "</table>";


            $dds_form_type_arr = array("formtype", $dds_form_type);
            array_push($fields, $dds_form_type_arr);

            if ($dds_form_type !== "mail_level2") {
                dds_form_db_log($fields, $dds_form_type);
            }


            ob_start();

            include(__DIR__ . '/mail_templates/basic_mail_template.php');
            $mailcontent = ob_get_clean();


            $to = $sp_contactmail;


            if (!empty($sendto)) {
                $to = $sendto;
            }

            $headers = 'From: ' . $sp_contactmail . "\r\n" .
                'Reply-To: ' . $client_email . "\r\n" .
                'Content-Type: text/html' . "\r\n" .
                'charset=UTF-8' . "\r\n";



            $sent = wp_mail($to, $subject, $mailcontent, $headers);
            if ($sent) {
                echo ("verstuurd");
            } else {
                echo ("error");
            }



            //second email

            if ($dds_form_type == "aankoop" && !empty($client_email)) {

                $headers2 = 'From: ' . $sp_contactmail . "\r\n" .
                    'Reply-To: ' . $client_email . "\r\n" .
                    'Content-Type: text/html' . "\r\n" .
                    'charset=UTF-8' . "\r\n";
                $merk = ucfirst($merk);
                $model = ucfirst($model);
                $second_subject = __("U ontvangt snel een bod voor uw ","dds-tools") . $merk . " " . $model;


                $second_mail_title =  "<strong>".__("U ontvangt snel een bod voor uw ","dds-tools")."</strong><br>" . $merk . " " . $model;
                $second_mail_main_con = "<h3>".__("Uw wagen gegevens:","dds-tools")."</h3>". $mail_main_con;
                $companytel = $sp_dealer_tel;
                $company_png = $sp_dealer_handelsnaam;
                $company = $sp_dealer_handelsnaam;

                $voetuig_mail = "auto";
                if(!empty($merkmobilhome)){
                    $voetuig_mail = "mobilhome";
                }
                
                ob_start();
                include(__DIR__ . '/mail_templates/basic_second_template.php');
                $secondmailcontent = ob_get_clean();

                try {
                    $sent = wp_mail($client_email, $second_subject, $secondmailcontent, $headers2);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }

            // 2de mail afspraak

            if ($dds_form_type == "afspraak" && !empty($client_email)) {

                $headers2 = 'From: ' . $sp_contactmail . "\r\n" .
                    'Reply-To: ' . $sp_contactmail . "\r\n" .
                    'Content-Type: text/html' . "\r\n" .
                    'charset=UTF-8' . "\r\n";

                $second_subject = $pagetitle . " | Uw afspraak is succesvol geboekt.";
                $second_mail_title = $pagetitle . " | Uw afspraak is succesvol geboekt.";
                $second_mail_main_con = "<h3>Uw afspraak is geboekt:</h3>" . $mail_main_con;
                $companytel = $sp_dealer_tel;
                $company_png = $sp_dealer_handelsnaam;
                $company = $sp_dealer_handelsnaam;
                ob_start();
                include(__DIR__ . '/mail_templates/afspraak_second_template.php');
                $secondmailcontent = ob_get_clean();

                try {
                    $sent = wp_mail($client_email, $second_subject, $secondmailcontent, $headers2);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            }
        }
    }
} else {
    header("HTTP/1.0 404 Not Found");
}
