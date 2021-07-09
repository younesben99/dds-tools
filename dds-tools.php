<?php

$dds_version = "1.70";

/*
Plugin Name: Digiflow DDS Tools
Plugin URI: https://github.com/younesben99/dds-tools
Description: Tools for DDS website.
Version: 1.70
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

//select2
wp_enqueue_script( 'select2_js', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js', array ( 'jquery' ), null, true);
wp_enqueue_style( 'select2_css', 'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css' );
wp_enqueue_script( 'main_dds_js', get_site_url() .'/wp-content/plugins/dds-tools/assets/js/dds_functions.js');
//dropzone
wp_enqueue_style( 'dropzonebasiccss', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.css' );
wp_enqueue_script( 'dropzonejs', 'https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.5.1/dropzone.js', array ( 'jquery' ), null, true);


wp_enqueue_style( 'dds_car_search_module', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_car_search.css?v='.$dds_version );
wp_enqueue_style( 'dds_forms', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_forms.css?v='.$dds_version );
wp_enqueue_script( 'dds_form_js', get_site_url() . '/wp-content/plugins/dds-tools/assets/js/dds_form.js?v='.$dds_version, array ( 'jquery' ), null, true);
wp_enqueue_style( 'fontawesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css' );






function dds_form_db_log($fields,$formtype){
  try {
    $mysqli = new mysqli("35.214.232.1", "uchrx69hijxdg", "1B%b13($21jn", "dbkafb9bwwracg");
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

 ?>