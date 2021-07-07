<?php


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{ 
    if (!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']==$_POST['url']) {



 if (isset($_POST["fields"])) {

            $fields = json_decode($_POST["fields"], true);
            
            

            include(__DIR__."/../../../../../wp-load.php");

            $imagelinks;
            if(!empty($_POST['dropzone_map'])){
                $imagedir = __DIR__. "/uploads/".$_POST['dropzone_map']."/";
                if (file_exists($imagedir)) {
                    try {
                        $current_image_map = scandir($imagedir);
                    
                        $imagelinks = array();
    
                        foreach ($current_image_map as $value) {
                            if (strlen($value) > 4) {
                                $link = get_site_url() . "/wp-content/plugins/dds-tools/modules/forms/uploads/".$_POST['dropzone_map'] . "/".$value;
                                array_push($imagelinks, $link);
                            }
                        }
                        //var_dump($imagelinks);
                    } catch (\Throwable $th) {
                        //throw $th;
                    }
                }
            }
            

            $dds_settings_options = get_option( 'dds_settings_option_name' );
        
            $sp_contactmail = $dds_settings_options['dealer_contact_mail'];
            $sp_dealer_tel = $dds_settings_options['dealer_tel_1_10'];
            $sp_dealer_handelsnaam = $dds_settings_options['dealer_handelsnaam_8'];
            $primary_color = $dds_settings_options['primary_color'];
            $hover_color = $dds_settings_options['hover_color'];

            $dds_form_type = $_POST["formtype"];

            foreach ($fields as $key => $value) {
                
                if(array_key_exists("emailadres",$value) || array_key_exists("mail",$value) || array_key_exists("email",$value)){
                    $valtemp = array_values($value);
                    $client_email = $valtemp[0];
                }
                if(array_key_exists("telefoonnummer",$value)){
                    $valtemp = array_values($value);
                    $tel = $valtemp[0];
                }
                if(array_key_exists("merk",$value)){
                    $valtemp = array_values($value);
                    $merk = $valtemp[0];
                }
                if(array_key_exists("model",$value)){
                    $valtemp = array_values($value);
                    $model = $valtemp[0];
                }

            }

           

            $merk = ucfirst($merk);
            $model = ucfirst($model);
            switch ($dds_form_type) {
                case 'aankoop':
                $mail_title = "Aangeboden wagen: ".$merk." ". $model;
                $subject = "Aangeboden wagen: ".$merk." ". $model;
                    break;
                case 'testrit':
                $mail_title = "Testrit geboekt voor de wagen: ".$merk." ". $model;
                $subject = "Testrit geboekt voor de wagen: ".$merk." ". $model;
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
                $mail_title = "Contactbericht";
                $subject = "Contactbericht";
                    break;
            }

            
            

           

            foreach ($fields as $key => $value) {
                
                $name = ucfirst(key($value));
                $value = $value[key($value)];
                
                if(!empty($value)){
                    if($name !== "Formtype" && $name !== "Dropzone_map"){
                        $mail_main_con .= "<b>". $name . "</b> : " . $value . "<br>";
                    }
                    
                }
                
                
            }

            $dds_form_type_arr = array("formtype",$dds_form_type);
            array_push($fields,$dds_form_type_arr);
            
            if($dds_form_type !== "mail_level2"){
                dds_form_db_log($fields,$dds_form_type);
            }
            
            
            ob_start();
            include(__DIR__.'/mail_templates/basic_mail_template.php');
            $mailcontent = ob_get_clean();


            $to = $sp_contactmail;
       

            $headers = 'From: '. $sp_contactmail . "\r\n" .
                'Reply-To: ' . $client_email . "\r\n" .
                'Content-Type: text/html' . "\r\n" .
                'charset=UTF-8'."\r\n";
        
        
        
            $sent = wp_mail($to, $subject, $mailcontent, $headers);
                if($sent) {
                    echo("verstuurd");
            }
                else  {
                    echo("error");
            }



            //second email

            if($dds_form_type == "aankoop" && !empty($client_email)){

                $headers2 = 'From: '. $sp_contactmail . "\r\n" .
                'Reply-To: ' . $sp_contactmail . "\r\n" .
                'Content-Type: text/html' . "\r\n" .
                'charset=UTF-8'."\r\n";
                $merk = ucfirst($merk);
                $model = ucfirst($model);
                $second_subject = "U ontvangt snel een bod voor uw ".$merk ." ". $model;
                $second_mail_title = "U ontvangt snel een bod voor uw voertuig: ".$merk ." ". $model;
                $second_mail_main_con = "<h3>Uw wagen gegevens:</h3>".$mail_main_con;
                $companytel = $sp_dealer_tel;
                $company_png = $sp_dealer_handelsnaam;
                $company = $sp_dealer_handelsnaam;
                ob_start();
                include(__DIR__.'/mail_templates/basic_second_template.php');
                $secondmailcontent = ob_get_clean();

                try {
                    $sent = wp_mail($client_email , $second_subject, $secondmailcontent, $headers2);
                } catch (\Throwable $th) {
                    //throw $th;
                }
           
           
            }

        }

    }
} 
else{ 
    header("HTTP/1.0 404 Not Found");
} 
