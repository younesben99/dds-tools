<?php


if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
{ 
    if (!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER']==$_POST['url']) {



 if (isset($_POST["fields"])) {

            $fields = json_decode($_POST["fields"], true);
            

            include(__DIR__."/../../../../../wp-load.php");

            $dds_settings_options = get_option( 'dds_settings_option_name' );
        
            $sp_contactmail = $dds_settings_options['dealer_contact_mail'];

            
            $dds_form_type = $_POST["formtype"];

            foreach ($fields as $key => $value) {
                
                if(array_key_exists("emailadres",$value) || array_key_exists("mail",$value) || array_key_exists("email",$value)){
                    $valtemp = array_values($value);
                    $email = $valtemp[0];
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

            $dds_form_type_arr = array("formtype",$dds_form_type);
            array_push($fields,$dds_form_type_arr);
            
            dds_form_db_log($fields,$dds_form_type);
            

           

            foreach ($fields as $key => $value) {
                
                $name = ucfirst(key($value));
                $value = $value[key($value)];
                
                if(!empty($value)){
                    $message .= "<b>". $name . "</b> : " . $value . "<br>";
                }
                
                
            }

            $to = $sp_contactmail;
       

            $headers = 'From: '. $email . "\r\n" .
                'Reply-To: ' . $email . "\r\n" .
                'Content-Type: text/html' . "\r\n" .
                'charset=UTF-8'."\r\n";
        
        
        
            $sent = wp_mail($to, $subject, $message, $headers);
                if($sent) {
                    
                    echo("verstuurd");
            }
                else  {
                    echo("error");
            }

        }

    }
} 
else{ 
    header("HTTP/1.0 404 Not Found");
} 
