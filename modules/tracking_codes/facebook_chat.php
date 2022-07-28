<?php

add_action ( 'wp_footer', 'fbchat' );
function fbchat() {
  $digiflow_settings_options = get_option( 'digiflow_settings_option_name' );
   ?>
	<!-- Load Facebook SDK for JavaScript -->
      <div id="fb-root"></div>
      <script>
        window.fbAsyncInit = function() {
          FB.init({
            xfbml            : true,
            version          : 'v10.0',
            logging          : true
          });
        };

        (function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = 'https://connect.facebook.net/nl_NL/sdk/xfbml.customerchat.js';
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
      </script>

      <!-- Your Chat Plugin code -->
      <div class="fb-customerchat"
        attribution="setup_tool"
        page_id="<?php echo($digiflow_settings_options['fb_chat_id_5']); ?>"
  theme_color="<?php echo($digiflow_settings_options['fb_chat_color_6']); ?>"
  logged_in_greeting="Hallo! Hoe kan ik u helpen?"
  logged_out_greeting="Hallo! Hoe kan ik u helpen?" mobile_bottom_spacing="100">
      </div>


<?php
}

?>