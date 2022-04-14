<?php

function dds_wizard( $atts) { 
 

    $a = shortcode_atts( array(
        'color' => 'white',
    ), $atts );

    $wizard = '<div id="ddswizard" style="background:'.$a['color'].';">'; 
     

    return $wizard;
} 

add_shortcode('dds_wizard', 'dds_wizard'); 


function dds_wizard_close() { 
 


    $dds_wizard_close = '</div>'; 
     

    return $dds_wizard_close;
} 

add_shortcode('dds_wizard_close', 'dds_wizard_close'); 

function dds_wizard_step($atts) { 
 
    $a = shortcode_atts( array(
        'text' => 'text',
        'p' => 'p'
    ), $atts );
   

    $step = '
    <h3></h3>
    <section>
        <h2>'.$a['text'].'</h2>
        <p>'.$a['p'].'</p>
        <div class="optieswrap">
        
'; 
     

    return $step;
} 

add_shortcode('dds_wizard_step', 'dds_wizard_step');

function dds_wizard_step_close() { 
 


    $dds_wizard_step_close = '</div>
    </section>'; 
     

    return $dds_wizard_step_close;
} 

add_shortcode('dds_wizard_step_close', 'dds_wizard_step_close'); 

function dds_wizard_optie($atts) { 
 
    $a = shortcode_atts( array(
        'text' => 'text',
        'img' => ''
    ), $atts );
   

    $step .= '<div class="singleoptiewrap">';
    
    if(!empty($a['img'])){
        $step .= '<img src="'.$a['img'].'" width="60" />';
    }

    $step .= '<span>'.$a['text'].'</span>';

    $step .= '</div>'; 
     

    return $step;
} 
add_shortcode('dds_wizard_optie', 'dds_wizard_optie');


function dds_wizard_input($atts) { 
 
    $a = shortcode_atts( array(
        'placeholder' => ''
    ), $atts );
   

    $step .= '<div class="singleinputwrap">';
    
    

    $step .= '<input type="text" class="dds_wizard_input" placeholder="'.$a['placeholder'].'"/>';

    $step .= '</div>'; 
     

    return $step;
} 
add_shortcode('dds_wizard_input', 'dds_wizard_input');


function dds_wizard_volgende($atts) { 
 
    $a = shortcode_atts( array(
        'text' => 'Next'
    ), $atts );
   


    
    

    $step .= '<button type="text" class="dds_next">'.$a['text'].'</button>';


     

    return $step;
} 
add_shortcode('dds_wizard_volgende', 'dds_wizard_volgende');

?>