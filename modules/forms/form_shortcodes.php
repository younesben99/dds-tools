<?php
//error_reporting(0);
function json_to_select_options($dir, $type){
    // deze functie werkt alleen als de json bestand 2 kollomen heeft genaamd ID en name
    $json = json_decode(file_get_contents($dir), true);
    $option = '';
    if($type == "merk"){
        foreach($json as $value){
            $option .= "<option data-merk='".$value["id"]."' value='".$value["name"]."'>".$value["name"]."</option>";
        }
    }
    else{
        foreach($json as $value){
            $option .= "<option style='display:none;' data-parent='".$value["makeId"]."' value='".$value["name"]."'>".$value["name"]."</option>";
        }
    }
    return $option;
}

function json_to_select_options_single_col($dir){
    // deze functie werkt alleen als de json bestand 1 kollom heeft genaamd ID en name
    $json = json_decode(file_get_contents($dir), true);
    $option = '';

    foreach($json as $value){
        $option .= "<option value='".$value['merk']."'>".$value['merk']."</option>";
    }
    $option .= "<option value='Andere'>".__("Andere", "dds-tools")."</option>";
    return $option;
}

function dds_input($atts) {
    $req = "";
    $data_hide = "";
    $hideinput = "";
    $placeholder = "";
    $name = "";
    $length = "";
    $ddsinputgroupcss = "";
    $width = "";
    $text = "";

    if (is_array($atts)) {
        if (in_array("*", $atts)) {
            $req = "required";
        }
        if (in_array("hide", $atts)) {
            $data_hide = " data-hide='true' ";
            $hideinput = "display:none;";
        }
    }

    if (!empty($atts["ph"])) {
        $placeholder = " placeholder='".$atts["ph"]."' ";
    }
    if (!empty($atts["name"])) {
        $name = " name='".strtolower($atts["name"])."' id='dds_id_".strtolower($atts["name"])."_".uniqid()."'";
    }
    if (!empty($atts["len"])) {
        $length = " maxlength='".$atts["len"]."' ";
    }
    if (!empty($atts["w"])) {
        $ddsinputgroupcss .= "width:".$atts["w"].";";
    }
    if ( isset(($atts["ty"]))) {
        $type =  " type='".$atts["ty"]."' ";
    } else {
        $type = " type='text' ";
    }

    if (isset($atts["ty"]) && $atts["ty"] == "textarea") {
        $text .= "<div class='dds_input_group' style='".$ddsinputgroupcss.$hideinput."'>";
        if (!empty($atts["lb"])) {
            $text .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
        }
        $text .= "<textarea ".$req.$name.$placeholder.$length.$width.$data_hide."></textarea>";
        $text .= "</div>";
    } else {
        $text .= "<div class='dds_input_group' style='".$ddsinputgroupcss.$hideinput."'>";
        if (!empty($atts["lb"])) {
            $text .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
        }
        $text .= "<input ".$type.$req.$name.$placeholder.$length.$width.$data_hide." />";
        $text .= "</div>";
    }
    

    return $text;
}


add_shortcode('dds_input', 'dds_input');

function dds_radio($atts) {
    $text = '';
    $req = '';
    $name = '';
    $selected_option = '';
    $options = array();

    if (is_array($atts)) {
        if (in_array("*", $atts)) {
            $req = " required";
        }
        if (!empty($atts["name"])) {
            $name = " name='".strtolower($atts["name"])."' id='dds_id_".strtolower($atts["name"])."'";
        }
        if (!empty($atts["selected"])) {
            $selected_option = strtolower($atts["selected"]);
        }
        if (!empty($atts["options"])) {
            $options = explode('|', $atts["options"]);
        }
    }

    $text .= "<div class='dds_radio_group'>";

    if (!empty($atts["lb"])) {
        $text .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
    }

    if (!empty($options)) {
        foreach ($options as $option) {
            $selected = '';
            $option_id = "dds_id_".strtolower($option)."_".uniqid();
            if (strtolower($option) == $selected_option) {
                $selected = ' checked';
            }
            $text .= "<div class='dds_radio_group_input'><input class='dds_radio_input' type='radio' value='".strtolower($option)."' id='".$option_id."'".$name.$selected."> <label class='dds_radio_label' for='".$option_id."'>".$option."</label></div>";
        }
    }

    $text .= "</div>";

    return $text;
}

add_shortcode('dds_radio', 'dds_radio');

function dds_select($atts) {
    $req = '';
    $data_hide = '';
    $hideinput = '';
    $d_range = "ma,di,wo,do,vr,za";
    $t_interval = 600;
    $start_uur = 10;
    $aantal_uren = 8;
    $excl_uren = array();
    $ddsinputgroupcss = '';
    $text = '';
    $name = '';
    $placeholder = '';
    $length = '';
    $width = '';
    $type = '';
    $intervalmins = '';

    if (is_array($atts)) {
        if (in_array("*", $atts)) {
            $req = "required";
        }
        if (in_array("hide", $atts)) {
            $data_hide = " data-hide='true' ";
            $hideinput = "display:none;";
        }
        if (!empty($atts["d_range"])) {
            $d_range = $atts["d_range"];
        }
        if (!empty($atts["t_interval"])) {
            $t_interval = intval($atts["t_interval"]);
        }
        if (!empty($atts["start_uur"])) {
            $start_uur = intval($atts["start_uur"]);
        }
        if (!empty($atts["aantal_uren"])) {
            $aantal_uren = intval($atts["aantal_uren"]);
        }
        if (!empty($atts["excl"])) {
            $atts["excl"] = explode(",", $atts["excl"]);
            foreach ($atts["excl"] as $key => $exclusion) {
                $excl_uren[$key]["dag"] = substr($exclusion, 0, 2);
                $excl_uren[$key]["t_range_start"] = get_string_between($exclusion, "(", "-");
                $excl_uren[$key]["t_range_end"] = get_string_between($exclusion, "-", ")");
                $excl_uren[$key]["interval"] = $t_interval;
            }
        }
    }

    if (!empty($atts["name"])) {
        $name = " name='".strtolower($atts["name"])."' id='dds_id_".strtolower($atts["name"])."_".uniqid()."'";
    }
    if (!empty($atts["len"])) {
        $length = " maxlength='".$atts["len"]."' ";
    }
    if (!empty($atts["w"])) {
        $ddsinputgroupcss .= "width:".$atts["w"].";";
    }
    if (!empty($atts["ty"])) {
        $type = $atts["ty"];
    }
    if (!empty($atts["intervalmins"])) {
        $intervalmins = $atts["intervalmins"];
    }

    $text .= "<div class='dds_input_group' style='".$ddsinputgroupcss.$hideinput."'>";
    if (!empty($atts["lb"])) {
        $text .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
    }

    // Handling options
    $options = array();
    if (!empty($atts["options"])) {
        $options = explode("|", $atts["options"]);
    }

    // Handling selected option
    $selected_option = '';
    if (!empty($atts["selected"])) {
        $selected_option = strtolower($atts["selected"]);
    }

    $text .= "<select ".$req.$name.$placeholder.$length.$width.$data_hide.">";

    if (!empty($atts["ph"])) {
        $text .= "<option value='' class='firstoption' hidden>".$atts["ph"]."</option>";
    }

    if (!empty($options)) {
        // If options parameter is set, use it to generate <option> tags
        foreach ($options as $option) {
            $selected = '';
            if (strtolower($option) == $selected_option) {
                $selected = ' selected';
            }
            $text .= "<option value='".strtolower($option)."'".$selected.">".$option."</option>";
        }
    } else {
        // If options parameter is not set, use predefined behavior
        switch (strtolower($atts["name"])) {
            // ... Your existing cases here ...
        }
    }

    switch (strtolower($atts["name"])) {
        case 'bouwjaar':
            for ($i=0; $i < 50; $i++) { 
                $jaar = date("Y") - $i;
                $text .= "<option value='".$jaar."'>".$jaar."</option>";
            }
            $text .= "<option value='oldtimer'>".__("Ouder dan 1971","dds-tools")."</option>";
            break;
        case 'brandstof':
            $text .= "<option value='benzine'>".__("Benzine","dds-tools")."</option>";
            $text .= "<option value='diesel'>".__("Diesel","dds-tools")."</option>";
            $text .= "<option value='hybride'>".__("Hybride","dds-tools")."</option>";
            $text .= "<option value='elektrisch'>".__("Elektrisch","dds-tools")."</option>";
            $text .= "<option value='lpg'>".__("LPG","dds-tools")."</option>";
            $text .= "<option value='cng'>".__("CNG","dds-tools")."</option>";
            $text .= "<option value='andere'>".__("Andere","dds-tools")."</option>";
            break;
        case 'merk':
            $text .= "<optgroup label='".__("Meest gekozen merken","dds-tools")."'>";
            $text .= json_to_select_options(__DIR__."/assets/top_merken.json","merk");
            $text .= "</optgroup>";
            $text .= "<optgroup label='".__("Alle merken [A-Z]","dds-tools")."'>";
            $text .= json_to_select_options(__DIR__."/assets/merken.json","merk");
            $text .= "</optgroup>";
            break;
        case 'merkmobilhome':
            $text .= json_to_select_options_single_col(__DIR__."/assets/mobilhome_merken.json");
            break;
        case 'datum':
            $datums = array();
            $myDate = date("l d F Y");

            for ($i=0; $i < 30; $i++) { 
                array_push($datums, strtotime($myDate . '+ '.$i.'days'));
            }

            //gekozen datums array klaarmaken
            $d_range = explode(',', $d_range);
            foreach($d_range as $index => $day){
                switch ($day) {
                    case 'ma':
                        $d_range[$index] = "Monday";
                        break;
                    case 'di':
                        $d_range[$index] = "Tuesday";
                        break;
                    case 'wo':
                        $d_range[$index] = "Wednesday";
                        break;
                    case 'do':
                        $d_range[$index] = "Thursday";
                        break;
                    case 'vr':
                        $d_range[$index] = "Friday";
                        break;
                    case 'za':
                        $d_range[$index] = "Saturday";
                        break;
                    case 'zo':
                        $d_range[$index] = "Sunday";
                        break;    
                }
            }

            foreach($datums as $date){
                $weekday = date('l', $date);
                if(in_array($weekday, $d_range)){
                    $dagvol = dds_nlDate(date("l d F Y", $date));
                    $dagkort = substr(strtolower(dds_nlDate(date("l", $date))), 0, 2);
                    $text .= "<option value=".$date." data-dag='".$dagkort."'>".$dagvol."</option>";   
                }
            }
            break;
        case 'tijd':
            $tijdstippen = array();
            $start_uur = $start_uur - 1;
            $aantal_uren = $aantal_uren + 1;
            $timebuffer = mktime($start_uur, 0, 0);
            $interval_secs = $t_interval;

            if (!empty($intervalmins)){
                $interval_secs = $intervalmins * 60;
            }

            $interval_remainer = 3600 / $interval_secs;
            $time_max = $aantal_uren * $interval_remainer;

            for ($i=0; $i < $time_max; $i++) { 
                $timebuffer += $interval_secs;
                array_push($tijdstippen, date("H:i", $timebuffer));
            }
            foreach($tijdstippen as $tijd){
                $text .= "<option value=".$tijd.">".$tijd."</option>";
            }
            break;
    }
    
    $text .= "</select>";

    if(!empty($excl_uren)){
        if(is_array($excl_uren)){
            $text .= "<div class='excl_tijd' data-excl-tijd='".json_encode($excl_uren)."' style='display:none !important;opacity:0;width:0;height:0;position:absolute;'></div>";
        }
    }
    $text .= "</div>";

    return $text;
}

add_shortcode('dds_select', 'dds_select');

function dds_form($atts) {
    global $current_formtype;
    $form = '';
    $home_url = home_url();
    $parsed_url = wp_parse_url($home_url);
    $domain = $parsed_url['host'];
    $style = '';
    $formtype = 'contactform';
    $formid = '';
    $sendto = '';
    $redirect = 'bedankt';

    if(!empty($atts)){
        if($atts['style'] == "modern"){
            $style = "dds_form_modern";
        }
        if($atts['style'] == "classic"){
            $style = "dds_form_classic";
        }
        if($atts['style'] == "classic_big"){
            $style = "dds_form_classic_big";
        }
        if (!empty($atts['type'])) {
            $formtype = $atts['type'];
        }
        if (!empty($atts["name"])) {
            $formid = "id='".$atts["name"]."' ";
        }
        if (!empty($atts["sendto"])) {
            $sendto = $atts["sendto"];
        }
        if(array_key_exists("redirect",$atts)){
            if($atts['redirect'] !== ""){
                $redirect = $atts['redirect'];
            }else{
                $redirect = "NO_REDIRECT";
            }
        }
    }
    $current_formtype = $formtype; // Store form type in global variable
    $form .= "<form action='/wp-content/plugins/dds-tools/modules/forms/form_fallback.php' method='POST' ".$formid." class='main_level1 dds_form ".$style."'>";
    if(is_archive()){
        $form .= "<input type='hidden' name='pagetitle' value='Stock' />";
        $form .= "<input type='hidden' name='pagelink' value='".get_post_type_archive_link("autos")."' />";
    } else {
        $form .= "<input type='hidden' name='pagetitle' value='".get_the_title()."' />";
        $form .= "<input type='hidden' name='pagelink' value='".get_permalink()."' />";
    }
    $form .= "<input type='hidden' class='dds_form_type' name='formtype' value='".$formtype."' />";
    $form .= "<input type='hidden' name='merk_hidden' class='merk_hidden' />";
    $form .= "<input type='hidden' name='model_hidden' class='model_hidden' />";
    $form .= "<input type='hidden' name='source' class='source_hidden' />";
    $form .= "<input type='hidden' name='gclid' class='gclid_hidden' />";
    $form .= "<input type='hidden' name='domain' class='domain_hidden' value='".$domain."'/>";
    $form .= "<input type='hidden' class='wizardlist' name='wizardlist' value='' />";
    $form .= "<input type='hidden' class='dds_redirect' name='dds_redirect' value='".$redirect."' />";
    $form .= "<input type='hidden' name='sendto' value='".$sendto."' />";
    $form .= "<input type='hidden' name='bodhlist' value='' />";
    // Hidden fields for URL parameters
    $form .= "<input type='hidden' name='keyword' value='' />";
    $form .= "<input type='hidden' name='placement' value='' />";
    $form .= "<input type='hidden' name='loc_interest' value='' />";
    $form .= "<input type='hidden' name='loc_physical' value='' />";
    $form .= "<input type='hidden' name='campaignid' value='' />";
    //dds_hp is een honeypot veld
    $form .= "<input type='text' name='firstname' style='opacity:0;position:absolute;top:0;left:0;height:0!important;width:0!important;z-index:-1;' autocomplete='off' tabindex='-1' />";
    $form .= "<input type='hidden' name='js_active' id='js_active' style='display:none;' />";
    return $form;
}

add_shortcode('dds_form', 'dds_form');

function close_dds_form() {
    global $current_formtype;

    // Default thank-you message
    $thank_you_message = __("Bedankt! Het bericht is succesvol verstuurd.", "dds-tools");

    // Customize the thank-you message based on formtype
    if (isset($current_formtype)) {
        switch ($current_formtype) {
            case 'beschikbaarheid':
                $thank_you_message = __("Bedankt! We hebben uw aanvraag voor beschikbaarheid ontvangen.", "dds-tools");
                break;
            case 'afspraak':
                $thank_you_message = __("Bedankt! Uw afspraak is succesvol ingepland.", "dds-tools");
                break;
            case 'bodh':
                $thank_you_message = __("Bedankt! We houden u op de hoogte van nieuwe aanbiedingen.", "dds-tools");
                break;
            // Add more cases as needed
            default:
                $thank_you_message = __("Bedankt! Het bericht is succesvol verstuurd.", "dds-tools");
        }
    }

    $form = '';
    $form .= "<div class='dds_form_thankyou_notice'><i class='fas fa-check' style='margin-right:5px;'></i> " . $thank_you_message . "</div>";
    $form .= "<div class='dds_form_error_notice'><i class='fas fa-exclamation-triangle' style='margin-right:5px;'></i> " . __("Error! Bekijk de velden en probeer opnieuw.", "dds-tools") . "</div>";
    $form .= "</form>";
    return $form;
}



add_shortcode('close_dds_form', 'close_dds_form');

function dds_submit($atts) {
    $dds_submit = '';
    if (!empty($atts)) {
        $submit_ph = isset($atts['ph']) ? $atts['ph'] : __("Versturen", "dds-tools");
        $submit_icon = '';

        if (isset($atts['icon'])) {
            $submit_icon_type = $atts['icon'];
            if (!empty($submit_icon_type)) {
                $submit_icon = "https://digiflowroot.be/static/images/icons/" . $submit_icon_type . ".svg";
            } else {
                $submit_icon = "";
            }
        }

        if (empty($submit_icon)) {
            $dds_submit .= "<button type='submit' class='dds_form_submit'>" . $submit_ph . "</button>";
        } else {
            $dds_submit .= "<button type='submit' class='dds_form_submit submit_icon_wrap'><div>" . $submit_ph . "</div><img src='" . $submit_icon . "' /></button>";
        }
    } else {
        $dds_submit .= "<button type='submit' class='dds_form_submit'>" . __("Versturen", "dds-tools") . "</button>";
    }
    return $dds_submit;
}


add_shortcode('dds_submit', 'dds_submit');

function dds_dropzone($atts) {
    $dds_dropzone = '';
    $data_hide = '';
    $hideinput = '';

    if (is_array($atts)) {
        if (in_array("hide", $atts)) {
            $data_hide = " data-hide='true' ";
            $hideinput = "display:none;";
        }
    }

    $dds_dropzone .= '<div class="dds_input_group" style="'.$hideinput.'">';
    if (!empty($atts["lb"])) {
        $dds_dropzone .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
    }
    $dds_dropzone .= '<div class="dropzone" id="dds_dropzone_'.uniqid().'" '.$data_hide.'></div>';
    $dds_dropzone .= "<input type='hidden' name='dropzone_map' class='dropzone_map_input' value='' />";
    $dds_dropzone .= '</div>';
    return $dds_dropzone;
}

add_shortcode('dds_dropzone', 'dds_dropzone');

function dds_form2($atts) {
    $form = '';
    $style = '';
    $sendto = '';

    if(!empty($atts)){
        if($atts['style'] == "modern"){
            $style = "dds_form_modern";
        }
        if($atts['style'] == "classic"){
            $style = "dds_form_classic";
        }
        if($atts['style'] == "classic_big"){
            $style = "dds_form_classic_big";
        }
        if (!empty($atts["sendto"])) {
            $sendto = $atts["sendto"];
        }
    }

    $form .= "<form action='/wp-content/plugins/dds-tools/modules/forms/form_fallback.php' method='POST' class='dds_form main_level2 ".$style."' style='display:none;'>";
    $form .= "<input type='hidden' class='dds_form_type' name='formtype' value='mail_level2' />";
    $form .= "<input type='hidden' class='dds_form_type merklevel2' name='merk' value='' />";
    $form .= "<input type='hidden' class='dds_form_type modellevel2' name='model' value='' />";
    $form .= "<input type='hidden' name='merk_hidden' class='merk_hidden' />";
    $form .= "<input type='hidden' name='model_hidden' class='model_hidden' />";
    $form .= "<input type='hidden' name='source' class='source_hidden' />";
    $form .= "<input type='hidden' name='pagelink' value='".get_permalink()."' />";
    $form .= "<input type='hidden' name='sendto' value='".$sendto."' />";
    return $form;
}

add_shortcode('dds_form2', 'dds_form2');

function close_dds_form2() {
    $form = '';
    $form .= "<div class='dds_form_thankyou_notice'><i class='fas fa-check' style='margin-right:5px;'></i> ".__("Bedankt! Het bericht is succesvol verstuurd.","dds-tools")."</div>";
    $form .= "<div class='dds_form_error_notice'><i class='fas fa-exclamation-triangle' style='margin-right:5px;'></i> ".__("Error! Bekijk de velden en probeer opnieuw.","dds-tools")."</div>";
    $form .= "</form>";
    return $form;
}

add_shortcode('close_dds_form2', 'close_dds_form2');
?>
