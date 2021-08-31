<?php
//error_reporting(0);
function json_to_select_options($dir,$type){
    // deze functie werkt alleen als de json bestand 2 kollomen heeft genaamd ID en name
    $json = json_decode(file_get_contents($dir),true);
    $option;
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
    $json = json_decode(file_get_contents($dir),true);
    $option;

    foreach($json as $value){
        $option .= "<option value='".$value['merk']."'>".$value['merk']."</option>";
    }
    $option .= "<option value='Andere'>Andere</option>";
    return $option;
}
function dds_input($atts)
{
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
    if (!empty($atts["ty"])) {
        $type = $atts["ty"];
    }
    if (empty($type)) {
        $type = " type='text' ";
    } else {
        $type =  " type='".$atts["ty"]."' ";
    }
    if($atts["ty"] == "textarea"){
        $text .= "<div class='dds_input_group' style='".$ddsinputgroupcss.$hideinput."'>";
        if (!empty($atts["lb"])) {
            $text .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
        }
        $text .= "<textarea ".$req.$name.$placeholder.$length.$width.$data_hide. "></textarea>";
       
        $text .= "</div>";
    }
    else{
        $text .= "<div class='dds_input_group' style='".$ddsinputgroupcss.$hideinput."'>";
    if (!empty($atts["lb"])) {
        $text .= "<label class='dds_form_label'>".$atts["lb"]."</label>";
    }
    $text .= "<input ".$type.$req.$name.$placeholder.$length.$width.$data_hide. " />";
   
    $text .= "</div>";
    }
   
    return $text;
}

add_shortcode('dds_input', 'dds_input');


function dds_select($atts)
{
    if (is_array($atts)) {
        if (in_array("*", $atts)) {
            $req = "required";
        }
        if (in_array("hide", $atts)) {
            $data_hide = " data-hide='true' ";
            $hideinput = "display:none;";
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
    $text .= "<select ".$req.$name.$placeholder.$length.$width.$data_hide. ">";

    if (!empty($atts["ph"])) {
        $text .= "<option value='' class='firstoption' hidden>".$atts["ph"]."</option>";
    }

    switch (strtolower($atts["name"])) {
        case 'bouwjaar':
            for ($i=0; $i < 50; $i++) { 
                $jaar = date("Y") - $i;
                $text .= "<option value='".$jaar."'>".$jaar."</option>";
            }
            $text .= "<option value='oldtimer'>Ouder dan 1971</option>";
            break;
        case 'brandstof':
            $text .= "<option value='benzine'>Benzine</option>";
            $text .= "<option value='diesel'>Diesel</option>";
            $text .= "<option value='hybride'>Hybride</option>";
            $text .= "<option value='elektrisch'>Elektrisch</option>";
            $text .= "<option value='lpg'>LPG</option>";
            $text .= "<option value='cng'>CNG</option>";
            $text .= "<option value='andere'>Andere</option>";
            break;
        case 'merk':
            $text .= "<optgroup label='Meest gekozen merken'>";
            $text .= json_to_select_options(__DIR__."/assets/top_merken.json","merk");
            $text .= "</optgroup>";
            $text .= "<optgroup label='Alle merken [A-Z]'>";
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
            foreach($datums as $date){
                $weekday = date('l', $date);
                if ($weekday !== "Sunday") {
                    $text .=  "<option value=".$date.">".dds_nlDate(date("l d F Y", $date))."</option>";
                }   
            }
            break;
        case 'tijd':
            $tijdstippen = array();

            $timebuffer = mktime(9,0,0);
            
            
            $interval_secs = apply_filters('custom_testrit_interval', 900);
            
            if(!empty($intervalmins)){
                $interval_secs = $intervalmins * 60;
            }

            $interval_remainer = 3600 / $interval_secs;


            
            $time_max = 9 * $interval_remainer;
        
        
            for ($i=0; $i < $time_max; $i++) { 
        
                
                $timebuffer += $interval_secs;
        
                array_push($tijdstippen, date("H:i",$timebuffer));
                
            }
            foreach($tijdstippen as $tijd){
                $text .= "<option value=".$tijd.">".$tijd."</option>";
            }
        
            break;
        
    }

    $text .= "</select>";
    
    $text .= "</div>";

    return $text;
}

add_shortcode('dds_select', 'dds_select');

function dds_form($atts)
{
    if(!empty($atts)){
        if($atts['style'] == "modern"){
            $style = "dds_form_modern";
        }
        if($atts['style'] == "classic"){
            $style = "dds_form_classic";
        }
        
        $formtype = $atts['type'];
        switch ($formtype) {
            case 'aankoop':
                $formtype = "aankoop";
                break;
            case 'beschikbaarheid':
                $formtype = "beschikbaarheid";
                break;
            case 'afspraak':
                $formtype = "afspraak";
                break;
            default:
                $formtype = "contactform";
                break;
        }
    }
    if (!empty($atts["name"])) {
        $formid = "id='".$atts["name"]."' ";
    }
    
    
    $form .= "<form action='/wp-content/plugins/dds-tools/modules/forms/form_fallback.php' method='POST' ".$formid." class='main_level1 dds_form ".$style."'>";
    $form .= "<input type='hidden' name='pagetitle' value='".get_the_title()."' />";
    $form .= "<input type='hidden' name='pagelink' value='".get_permalink()."' />";
    $form .= "<input type='hidden' class='dds_form_type' name='formtype' value='".$formtype."' />";
    $form .= "<input type='hidden' name='merk_hidden' class='merk_hidden' />";
    $form .= "<input type='hidden' name='model_hidden' class='model_hidden' />";

    return $form;
}

add_shortcode('dds_form', 'dds_form');


function close_dds_form()
{
    
    $form .= "<div class='dds_form_thankyou_notice'><i class='fas fa-check' style='margin-right:5px;'></i> Bedankt! Het bericht is succesvol verstuurd.</div>";
    $form .= "<div class='dds_form_error_notice'><i class='fas fa-exclamation-triangle' style='margin-right:5px;'></i> Error! Bekijk de velden en probeer opnieuw</div>";
    $form .= "</form>";
    return $form;
}

add_shortcode('close_dds_form', 'close_dds_form');


function dds_submit($atts)
{
    if(!empty($atts)){
        if($atts['ph']){
            $submit_ph = $atts['ph'];
        }
        $dds_submit .= "<button type='submit' class='dds_form_submit'>".$submit_ph."</button>";
    }
    else{
        $dds_submit .= "<button type='submit' class='dds_form_submit'>Versturen</button>";
    }
    

    return $dds_submit;
}

add_shortcode('dds_submit', 'dds_submit');


function dds_dropzone($atts)
{
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

//tweede level

function dds_form2($atts)
{
    if(!empty($atts)){
        if($atts['style'] == "modern"){
            $style = "dds_form_modern";
        }
        if($atts['style'] == "classic"){
            $style = "dds_form_classic";
        }
        
    }
    
    $form .= "<form action='/wp-content/plugins/dds-tools/modules/forms/form_fallback.php' method='POST' class='dds_form main_level2 ".$style."' style='display:none;'>";
    $form .= "<input type='hidden' class='dds_form_type' name='formtype' value='mail_level2' />";
    $form .= "<input type='hidden' class='dds_form_type merklevel2' name='merk' value='' />";
    $form .= "<input type='hidden' class='dds_form_type modellevel2' name='model' value='' />";
    return $form;
}

add_shortcode('dds_form2', 'dds_form2');


function close_dds_form2()
{
   
    $form .= "<div class='dds_form_thankyou_notice'><i class='fas fa-check' style='margin-right:5px;'></i> Bedankt! Het bericht is succesvol verstuurd.</div>";
    $form .= "<div class='dds_form_error_notice'><i class='fas fa-exclamation-triangle' style='margin-right:5px;'></i> Error! Bekijk de velden en probeer opnieuw</div>";
    $form .= "</form>";
    return $form;
}

add_shortcode('close_dds_form2', 'close_dds_form2');