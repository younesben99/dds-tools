<?php

$dds_version = "5.1.1";

/*
Plugin Name: Digiflow DDS Tools
Plugin URI: https://github.com/younesben99/dds-tools
Description: Tools for DDS website.
Version: 5.1.1
Author: Younes Benkheil
Author URI: https://digiflow.be/
License: GPL2
GitHub Plugin URI: https://github.com/younesben99/dds-tools
*/

include(__DIR__."/admin-panel/dds_tracking_panel.php");
include(__DIR__."/admin-panel/dds_form_settings.php");
include(__DIR__."/generate-pages/privacypolicy/generate_privacy_policy.php");
include(__DIR__."/modules/meldingen/cookie_melding/cookie_melding.php");
include(__DIR__."/modules/tracking_codes/analytics_parser.php");
include(__DIR__."/modules/search/dds_car_search.php");
include(__DIR__."/modules/forms/form_shortcodes.php");
include(__DIR__."/modules/shortcodes/dds_shortcodes.php");
include(__DIR__."/modules/wizard/wizard.php");

wp_enqueue_script( 'jquerysteps', get_site_url() . '/wp-content/plugins/dds-tools/assets/js/jquery.steps.min.js?v='.$dds_version, array ( 'jquery' ), null, true);
wp_enqueue_script( 'dds_wizard', get_site_url() . '/wp-content/plugins/dds-tools/assets/js/dds_wizard.js?v='.$dds_version, array ( 'jquery' ), null, true);
//select2
wp_enqueue_script( 'select2_js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array ( 'jquery' ), null, true);
wp_enqueue_style( 'select2_css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
wp_enqueue_script( 'main_dds_js', get_site_url() .'/wp-content/plugins/dds-tools/assets/js/dds_functions.js' );
//dropzone
wp_enqueue_style( 'dropzonebasiccss', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css' );
wp_enqueue_script( 'dropzonejs', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js', array ( 'jquery' ), null, true);


wp_enqueue_style( 'dds_car_search_module', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_car_search.css?v='.$dds_version );
wp_enqueue_style( 'dds_forms', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_forms.css?v='.$dds_version );
wp_enqueue_script( 'dds_form_js', get_site_url() . '/wp-content/plugins/dds-tools/assets/js/dds_form.js?v='.$dds_version, array ( 'jquery' ), null, true);
wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' );

wp_localize_script('dds_form_js','dds_main_vars',array('siteurl'=>get_site_url()));
wp_enqueue_style( 'dds_wizard', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_wizard.css?v='.$dds_version );
wp_enqueue_script('dds_car_search_module', get_site_url() . '/wp-content/plugins/dds-tools/assets/js/dds_car_search.js?v='.$dds_version, array( 'jquery' ), false, true);


function dds_nlDate($datum){ 

    $datum = str_replace("january",     "januari",         $datum); 
     $datum = str_replace("february",     "februari",     $datum); 
    $datum = str_replace("march",         "maart",         $datum); 
     $datum = str_replace("april",         "april",         $datum); 
     $datum = str_replace("may",         "mei",             $datum); 
     $datum = str_replace("june",         "juni",         $datum); 
    $datum = str_replace("july",         "juli",         $datum); 
    $datum = str_replace("august",         "augustus",     $datum); 
     $datum = str_replace("september",     "september",     $datum); 
     $datum = str_replace("october",     "oktober",         $datum); 
     $datum = str_replace("november",     "november",     $datum); 
    $datum = str_replace("december",     "december",     $datum); 

    // Vervang de maand, hoofdletters 
   $datum = str_replace("January",     "Januari",         $datum); 
     $datum = str_replace("February",     "Februari",     $datum); 
    $datum = str_replace("March",         "Maart",         $datum); 
     $datum = str_replace("April",         "April",         $datum); 
     $datum = str_replace("May",         "Mei",             $datum); 
     $datum = str_replace("June",         "Juni",         $datum); 
    $datum = str_replace("July",         "Juli",         $datum); 
    $datum = str_replace("August",         "Augustus",     $datum); 
     $datum = str_replace("September",     "September",     $datum); 
     $datum = str_replace("October",     "Oktober",         $datum); 
     $datum = str_replace("November",     "November",     $datum); 
    $datum = str_replace("December",     "December",     $datum); 

   
     $datum = str_replace("Jan",         "Jan",             $datum); 
     $datum = str_replace("Feb",         "Feb",             $datum); 
     $datum = str_replace("Mar",         "Maa",             $datum); 
     $datum = str_replace("Apr",         "Apr",             $datum); 
     $datum = str_replace("May",         "Mei",             $datum); 
     $datum = str_replace("Jun",         "Jun",             $datum); 
     $datum = str_replace("Jul",         "Jul",             $datum); 
     $datum = str_replace("Aug",         "Aug",             $datum); 
     $datum = str_replace("Sep",         "Sep",             $datum); 
     $datum = str_replace("Oct",         "Ok",             $datum); 
   $datum = str_replace("Nov",         "Nov",             $datum); 
     $datum = str_replace("Dec",         "Dec",             $datum); 

  
   $datum = str_replace("monday",         "maandag",         $datum); 
     $datum = str_replace("tuesday",     "dinsdag",         $datum); 
     $datum = str_replace("wednesday",     "woensdag",     $datum); 
   $datum = str_replace("thursday",     "donderdag",     $datum); 
   $datum = str_replace("friday",         "vrijdag",         $datum); 
     $datum = str_replace("saturday",     "zaterdag",     $datum); 
    $datum = str_replace("sunday",         "zondag",         $datum); 


     $datum = str_replace("Monday",         "Maandag",         $datum); 
     $datum = str_replace("Tuesday",     "Dinsdag",         $datum); 
     $datum = str_replace("Wednesday",     "Woensdag",     $datum); 
   $datum = str_replace("Thursday",     "Donderdag",     $datum); 
   $datum = str_replace("Friday",         "Vrijdag",         $datum); 
     $datum = str_replace("Saturday",     "Zaterdag",     $datum); 
    $datum = str_replace("Sunday",         "Zondag",         $datum); 

     $datum = str_replace("Mon",            "Maa",             $datum); 
     $datum = str_replace("Tue",         "Din",             $datum); 
     $datum = str_replace("Wed",         "Woe",             $datum); 
     $datum = str_replace("Thu",         "Don",             $datum); 
     $datum = str_replace("Fri",         "Vri",             $datum); 
     $datum = str_replace("Sat",         "Zat",             $datum); 
     $datum = str_replace("Sun",         "Zon",             $datum); 

    return $datum; 
}


function dds_form_db_log($fields,$formtype){
  try {
    $mysqli = new mysqli("35.214.174.30", "uchrx69hijxdg", "1B%b13($21jn", "dbkafb9bwwracg",3306);
    $mysqli->select_db("dbkafb9bwwracg") or die( "Unable to select database");
    
    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }
    
    
    foreach ($fields as $key => $value) {
        if(is_array($value)){
            if(array_key_exists("emailadres",$value) || array_key_exists("mail",$value) || array_key_exists("email",$value)){
                $valtemp = array_values($value);
                $email = $valtemp[0];
            }
            if(array_key_exists("telefoonnummer",$value) || array_key_exists("tel",$value)){
                $valtemp = array_values($value);
                $tel = $valtemp[0];
            }
        }
    }
    
    
    $fields = json_encode($fields);
    
    $timestamp = date_create('Europe/Brussels')->format('Y-m-d H:i:s');
    $id = uniqid();
    
    
    $sql = "INSERT INTO dds_form (id,json_fields, client_mail, client_tel,timestamp_submission,formtype)
    VALUES ('$id','$fields', '$email', '$tel','$timestamp','$formtype')";
    
    if ($mysqli->query($sql) !== TRUE) {
        echo "Error: " . $sql . "<br>" . $mysqli->error;
    } 
    
    $mysqli->close();
  } catch (\Throwable $th) {
      //throw $th;
  }


}


if(!function_exists("get_string_between")){
  function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}


}


//slugify

if(!function_exists("slugify")){
  function slugify($text, string $divider = '-')
  {
    // replace non letter or digits by divider
    $text = preg_replace('~[^\pL\d]+~u', $divider, $text);
  
    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
  
    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);
  
    // trim
    $text = trim($text, $divider);
  
    // remove duplicate divider
    $text = preg_replace('~-+~', $divider, $text);
  
    // lowercase
    $text = strtolower($text);
  
    if (empty($text)) {
      return 'n-a';
    }
  
    return $text;
  }
  }



// Remove or unregister unused WordPress Image Sizes
function cdxn_remove_intermediate_image_sizes($sizes, $metadata) {
  $disabled_sizes = array(
      'thumbnail',
      'medium_large',
      'large',
      'post-thumbnail',
      'post-single-image',
      'post-large-image',
      'post-custom-image'
  );
  // unset disabled sizes
  foreach ($disabled_sizes as $size) {
      if (!isset($sizes[$size])) {
          continue;
      }
      unset($sizes[$size]);
  }
  return $sizes;
}
// Hook the function
add_filter('intermediate_image_sizes_advanced', 'cdxn_remove_intermediate_image_sizes', 10, 2);

 ?>