<?php
function log_error($message) {
    $log_file = __DIR__ . "/error_log.log";
    $formatted_message = $message . PHP_EOL . PHP_EOL;
    error_log($formatted_message, 3, $log_file);

    // Send error to remote server
    $ch = curl_init('https://digiflowroot.be/logs/server-handler.php');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('error' => $message)));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $curl_error = curl_error($ch);
    $curl_errno = curl_errno($ch);
    curl_close($ch);

    if ($curl_errno) {
        $formatted_message = "Failed to send error log to remote server. CURL Error: $curl_error (Error Code: $curl_errno)" . PHP_EOL . PHP_EOL;
        error_log($formatted_message, 3, $log_file);
    }
}

// Function to log and output messages
function log_and_echo($message, $context = '') {
    $full_message = $message . ($context ? " | Context: " . json_encode($context) : '');
    log_error($full_message);
    echo $message;
}

// Function to clean and extract valuable information from the mail content
function clean_mail_content($content) {
    $dom = new DOMDocument;
    libxml_use_internal_errors(true);
    $dom->loadHTML($content);
    libxml_clear_errors();

    $xpath = new DOMXPath($dom);
    $table_rows = $xpath->query('//table[contains(@class, "mail_main_table")]//tr');

    $cleaned_content = '';
    foreach ($table_rows as $row) {
        $cells = $row->getElementsByTagName('td');
        $row_data = [];
        foreach ($cells as $cell) {
            $row_data[] = trim($cell->textContent);
        }
        $cleaned_content .= implode(": ", $row_data) . PHP_EOL;
    }

    $cleaned_content = preg_replace('/\s+/', ' ', $cleaned_content);
    $cleaned_content = trim($cleaned_content);
    $cleaned_content = substr($cleaned_content, 0, 1000);

    return $cleaned_content;
}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    if (!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] == $_POST['url']) {

        if (isset($_POST["fields"])) {
            $fields_arr = json_decode($_POST["fields"], true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                log_and_echo("JSON decode error: " . json_last_error_msg());
                exit;
            }

            $fields = array();
            foreach ($fields_arr as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $sub_key => $sub_value) {
                        $fields[$sub_key] = htmlspecialchars($sub_value, ENT_QUOTES, 'UTF-8');
                    }
                } else {
                    $fields[$key] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                }
            }

            $tel = $merk = $model = $client_email = $bouwjaar = $brandstof = $pagetitle = $pagelink_dds = $sendto = $kilometerstand = $dds_form_type = $bodhlist = $dienst = $source = $gclid = $domain = $merkmobilhome = '';

            if (!empty($fields["telefoonnummer"])) $tel = $fields["telefoonnummer"];
            if (!empty($fields["merk"])) $merk = $fields["merk"];
            if (!empty($fields["model"])) $model = $fields["model"];
            if (empty($merk) && !empty($fields["merk_hidden"])) $merk = $fields["merk_hidden"];
            if (empty($model) && !empty($fields["model_hidden"])) $model = $fields["model_hidden"];
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
            if (!empty($fields["merkmobilhome"])) {
                $merkmobilhome = $fields["merkmobilhome"];
                $merk = $merkmobilhome;
                $model = $fields["model"];
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

            if (!empty($kilometerstand) && is_numeric($kilometerstand)) {
                $as_url_params["kmto"] = $kilometerstand + 25000;
            }

            $as_url_params = http_build_query($as_url_params);
            $as_url_link = "https://www.autoscout24.be/nl/lst/" . slugify($merk) . "/" . slugify($model) . "/ft_" . slugify($brandstof) . "?" . $as_url_params;

            $merk = ucfirst($merk);
            $model = ucfirst($model);

            $imagelinks = array();
            if (!empty($_POST['dropzone_map'])) {
                $dropzone_map = htmlspecialchars($_POST['dropzone_map'], ENT_QUOTES, 'UTF-8');
                $imagedir = __DIR__ . "/../../../../uploads/dds_dropzone/" . $dropzone_map . "/";
                if (file_exists($imagedir)) {
                    try {
                        $current_image_map = scandir($imagedir);
                        foreach ($current_image_map as $value) {
                            if (strlen($value) > 4) {
                                $link = get_site_url() . "/wp-content/uploads/dds_dropzone/" . $dropzone_map . "/" . htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                                array_push($imagelinks, $link);
                            }
                        }
                    } catch (\Throwable $th) {
                        log_error("Image processing error: " . $th->getMessage());
                    }
                }
            }

            $dds_settings_options = get_option('dds_settings_option_name', []);
            $digiflow_settings_options = get_option('digiflow_settings_option_name', []);

            $sp_contactmail = !empty($dds_settings_options['dealer_contact_mail']) ? htmlspecialchars($dds_settings_options['dealer_contact_mail'], ENT_QUOTES, 'UTF-8') : (!empty($digiflow_settings_options['company_mail']) ? htmlspecialchars($digiflow_settings_options['company_mail'], ENT_QUOTES, 'UTF-8') : 'younesbenkheil@gmail.com');
            $sp_dealer_tel = !empty($dds_settings_options['dealer_tel_1_10']) ? htmlspecialchars($dds_settings_options['dealer_tel_1_10'], ENT_QUOTES, 'UTF-8') : (!empty($digiflow_settings_options['company_tel']) ? htmlspecialchars($digiflow_settings_options['company_tel'], ENT_QUOTES, 'UTF-8') : '0000000000');
            $sp_dealer_handelsnaam = !empty($dds_settings_options['dealer_handelsnaam_8']) ? htmlspecialchars($dds_settings_options['dealer_handelsnaam_8'], ENT_QUOTES, 'UTF-8') : (!empty($digiflow_settings_options['company_name']) ? htmlspecialchars($digiflow_settings_options['company_name'], ENT_QUOTES, 'UTF-8') : 'Bedrijfsnaam niet opgegeven');
            $primary_color = !empty($dds_settings_options['primary_color']) ? htmlspecialchars($dds_settings_options['primary_color'], ENT_QUOTES, 'UTF-8') : "#3071AD";
            $hover_color = !empty($dds_settings_options['hover_color']) ? htmlspecialchars($dds_settings_options['hover_color'], ENT_QUOTES, 'UTF-8') : "#3071AD";
            $sp_locatie = !empty($dds_settings_options['dealer_city_9']) ? htmlspecialchars($dds_settings_options['dealer_city_9'], ENT_QUOTES, 'UTF-8') : '';
            $sp_locatielink = !empty($dds_settings_options['sp_locatie_link']) ? htmlspecialchars($dds_settings_options['sp_locatie_link'], ENT_QUOTES, 'UTF-8') : '';

            switch ($dds_form_type) {
                case 'aankoop':
                    $mail_title = empty($merkmobilhome) ? "Aangeboden wagen: $merk $model $bouwjaar" : "Aangeboden Mobilhome: $merk $model $bouwjaar";
                    $subject = $mail_title;
                    $show_as_search = empty($merkmobilhome);
                    break;
                case 'afspraak':
                    if (!empty($merk) && !empty($model)) {
                        $mail_title = "Afspraak geboekt voor de wagen: $merk $model";
                        $subject = $mail_title;
                    } else {
                        $mail_title = "$pagetitle | Afspraak is succesvol geboekt.";
                        $subject = $mail_title;
                    }
                    break;
                case 'beschikbaarheid':
                    $mail_title = "Contactbericht: $merk $model";
                    $subject = $mail_title;
                    break;
                case 'mail_level2':
                    $mail_title = "Extra gegevens: $merk $model";
                    $subject = $mail_title;
                    break;
                case 'offerte':
                    $mail_title = "Offerte ontvangen voor: $dienst";
                    $subject = $mail_title;
                    break;
                case 'bodh':
                    $mail_title = empty($merk) ? "Blijf op de hoogte: $client_email" : "Blijf op de hoogte: $merk $model";
                    $subject = $mail_title;
                    break;
                default:
                    $mail_title = "Contactbericht | $pagetitle";
                    $subject = $mail_title;
                    break;
            }

            $mail_main_con = "<table class='mail_main_table' style='width: 100%;'>";
            foreach ($fields as $key => $value) {
                if (!empty($value)) {
                    $name = ucfirst($key);

                    if ($name == "Datum") {
                        $unix_datum = intval($value);
                        $mail_main_con .= "<tr><td class='nametd'>Locatie</td><td><b><a href='$sp_locatielink'>$sp_locatie</a></b></td></tr>";
                        $mail_main_con .= "<tr><td class='nametd'>$name</td><td><b>" . dds_nlDate(date("l d F Y", $unix_datum)) . "</b></td></tr>";
                    } elseif ($name == "Wizardlist") {
                        $wizard_json = json_decode($value, true);
                        foreach ($wizard_json as $key => $wizard_value) {
                            if (is_array($wizard_value)) {
                                $wizard_value = implode(" ", $wizard_value);
                                $mail_main_con .= "<tr><td class='nametd'>$key</td><td><b>$wizard_value</b></td></tr>";
                            } else {
                                $mail_main_con .= "<tr><td class='nametd'>$key</td><td><b>$wizard_value</b></td></tr>";
                            }
                        }
                    } elseif ($name !== "Bodhlist" && $name !== "Domain" && $name !== "Source" && $name !== "Wizardlist" && $name !== "Js_active" && $name !== "Formtype" && $name !== "Dropzone_map" && $name !== "Datum" && $name !== "Merk_hidden" && $name !== "Model_hidden" && $name !== "Pagelink" && $name !== "Pagetitle" && $name !== "Sendto" && $name !== "Dds_redirect" && $name !== "Gclid") {
                        switch ($name) {
                            case 'Merk':
                            case 'Merkmobilhome':
                                $name = __("Merk", "dds-tools");
                                break;
                            case 'Model':
                                $name = __("Model", "dds-tools");
                                break;
                            case 'Brandstof':
                                $name = __("Brandstof", "dds-tools");
                                break;
                            case 'Bouwjaar':
                                $name = __("Bouwjaar", "dds-tools");
                                break;
                            case 'Kilometerstand':
                                $name = __("Kilometerstand", "dds-tools");
                                break;
                            case 'Telefoonnummer':
                                $name = __("Telefoonnummer", "dds-tools");
                                break;
                            case 'Emailadres':
                                $name = __("Emailadres", "dds-tools");
                                break;
                            case 'Merk & Model':
                                $name = __("Merk & Model", "dds-tools");
                                break;
                        }
                        $mail_main_con .= "<tr><td class='nametd'>$name</td><td><b>$value</b></td></tr>";
                    } elseif ($name == "Bodhlist") {
                        $bodhlist_array = json_decode($bodhlist, true);
                        foreach ($bodhlist_array as $key => $bodh_value) {
                            if (!is_array($bodh_value)) {
                                $mail_main_con .= "<tr><td class='nametd'>Geslecteerde Filter: " . ucfirst($key) . "</td><td><b>$bodh_value</b></td></tr>";
                            } else {
                                $mail_main_con .= "<tr><td class='nametd'>Geslecteerde Filter: " . ucfirst($key) . "</td><td><b>";
                                $mail_main_con .= implode(" | ", preg_replace("/[^A-Za-z0-9]/", "", $bodh_value));
                                $mail_main_con .= "</b></td></tr>";
                            }
                        }
                    }
                }
            }
            $mail_main_con .= "</table>";

            $dds_form_type_arr = array("formtype", $dds_form_type);
            $fields[] = $dds_form_type_arr;

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

            add_action('wp_mail_failed', 'capture_wp_mail_failed');
            function capture_wp_mail_failed($wp_error) {
                global $mail_error;
                $mail_error = $wp_error;
            }

            $mail_content_cleaned = clean_mail_content($mailcontent);

            $sent = wp_mail($to, $subject, $mailcontent, $headers);
            if ($sent) {
                log_and_echo("Mail sent successfully");
            } else {
                global $mail_error;
                $stack_trace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);

                log_and_echo("Mail sending error. To: $to, Subject: $subject, Inhoud: $mail_content_cleaned, Headers: " . json_encode($headers), [
                    'error' => $mail_error->get_error_message(),
                    'error_data' => $mail_error->get_error_data(),
                    'stack_trace' => $stack_trace
                ]);
            }

            if ($dds_form_type == "aankoop" && !empty($client_email)) {
                $headers2 = 'From: ' . $sp_contactmail . "\r\n" .
                    'Reply-To: ' . $client_email . "\r\n" .
                    'Content-Type: text/html' . "\r\n" .
                    'charset=UTF-8' . "\r\n";
                $second_subject = __("U ontvangt snel een bod voor uw ", "dds-tools") . $merk . " " . $model;
                $second_mail_title = "<strong>" . __("U ontvangt snel een bod voor uw ", "dds-tools") . "</strong><br>$merk $model";
                $second_mail_main_con = "<h3>" . __("Uw wagen gegevens:", "dds-tools") . "</h3>" . $mail_main_con;
                $companytel = $sp_dealer_tel;
                $company_png = $sp_dealer_handelsnaam;
                $company = $sp_dealer_handelsnaam;
                $voetuig_mail = !empty($merkmobilhome) ? "mobilhome" : "auto";

                ob_start();
                include(__DIR__ . '/mail_templates/basic_second_template.php');
                $secondmailcontent = ob_get_clean();

                try {
                    $sent = wp_mail($client_email, $second_subject, $secondmailcontent, $headers2);
                    if (!$sent) {
                        log_error("Failed to send second email (aankoop)");
                    }
                } catch (\Throwable $th) {
                    log_error("Error in second email (aankoop): " . $th->getMessage());
                }
            }

            if ($dds_form_type == "afspraak" && !empty($client_email)) {
                $headers2 = 'From: ' . $sp_contactmail . "\r\n" .
                    'Reply-To: ' . $sp_contactmail . "\r\n" .
                    'Content-Type: text/html' . "\r\n" .
                    'charset=UTF-8' . "\r\n";

                $second_subject = "$pagetitle | Uw afspraak is succesvol geboekt.";
                $second_mail_title = $second_subject;
                $second_mail_main_con = "<h3>Uw afspraak is geboekt:</h3>$mail_main_con";
                $companytel = $sp_dealer_tel;
                $company_png = $sp_dealer_handelsnaam;
                $company = $sp_dealer_handelsnaam;

                ob_start();
                include(__DIR__ . '/mail_templates/afspraak_second_template.php');
                $secondmailcontent = ob_get_clean();

                try {
                    $sent = wp_mail($client_email, $second_subject, $secondmailcontent, $headers2);
                    if (!$sent) {
                        log_error("Failed to send second email (afspraak)");
                    }
                } catch (\Throwable $th) {
                    log_error("Error in second email (afspraak): " . $th->getMessage());
                }
            }
        } else {
            log_and_echo("No fields provided in the POST request.");
        }
    } else {
        log_and_echo("Invalid HTTP_REFERER or it does not match the POST URL.");
    }
} else {
    log_and_echo("Invalid request type or missing HTTP_X_REQUESTED_WITH header.");
    header("HTTP/1.0 404 Not Found");
}
?>
