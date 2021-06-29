<?php

function dds_input($atts)
{
    if (is_array($atts)) {
        if (in_array("*", $atts)) {
            $req = "required";
        }
    }

    if (!empty($atts["ph"])) {
        $placeholder = " placeholder='".$atts["ph"]."' ";
    }
    if (!empty($atts["name"])) {
        $name = " name='".strtolower($atts["name"])."' id='dds_id_".strtolower($atts["name"])."'";
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
    if (!empty($atts["lb"])) {
        $text .= "<div class='dds_input_group' style='".$ddsinputgroupcss."'><label class='dds_form_label'>".$atts["lb"]."</label>";
    }
    $text .= "<input ".$type.$req.$name.$placeholder.$length.$width. " />";
    if (!empty($atts["lb"])) {
        $text .= "</div>";
    }
    return $text;
}

add_shortcode('dds_input', 'dds_input');



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
            case 'testrit':
                $formtype = "testrit";
                break;
            case 'beschikbaarheid':
                $formtype = "beschikbaarheid";
                break;
                
            default:
                $formtype = "contactform";
                break;
        }
    }
    if (!empty($atts["name"])) {
        $formid = "id='".$atts["name"]."' ";
    }
    
    $form .= "<form action='/wp-content/plugins/dds-tools/modules/forms/form_fallback.php' method='POST' ".$formid." class='dds_form ".$style."'>";
    $form .= "<input type='hidden' class='dds_form_type' name='formtype' value='".$formtype."' />";

    return $form;
}

add_shortcode('dds_form', 'dds_form');


function close_dds_form()
{
    $form .= "</form>";
    $form .= "<div class='dds_form_thankyou_notice'><i class='fas fa-check' style='margin-right:5px;'></i> Bedankt! Het bericht is succesvol verstuurd.</div>";
    $form .= "<div class='dds_form_error_notice'><i class='fas fa-exclamation-triangle' style='margin-right:5px;'></i> Error! Bekijk de velden en probeer opnieuw</div>";
    return $form;
}

add_shortcode('close_dds_form', 'close_dds_form');


function dds_submit()
{
    $dds_submit .= "<button type='submit' class='dds_form_submit'>Versturen</button>";

    return $dds_submit;
}

add_shortcode('dds_submit', 'dds_submit');
