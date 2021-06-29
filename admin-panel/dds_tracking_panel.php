<?php

class DigiflowSettings {
	private $digiflow_settings_options;

	public function __construct() {
		add_action( 'admin_menu', array( $this, 'digiflow_settings_add_plugin_page' ) );
		add_action( 'admin_init', array( $this, 'digiflow_settings_page_init' ) );
	}

	public function digiflow_settings_add_plugin_page() {
		add_menu_page(
			'Digiflow Settings', // page_title
			'Digiflow Settings', // menu_title
			'manage_options', // capability
			'digiflow-settings', // menu_slug
			array( $this, 'digiflow_settings_create_admin_page' ), // function
			'dashicons-admin-network', // icon_url
			2 // position
		);
        add_submenu_page( 'digiflow-settings', 'Form settings', 'Form settings', 'manage_options', 'dds_form_settings', 'digiflow_form_settings_callback');

	}

	public function digiflow_settings_create_admin_page() {
		$this->digiflow_settings_options = get_option( 'digiflow_settings_option_name' ); ?>

		<div class="wrap">

		

			
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
            <h2>Digiflow Settings</h2>
                <p>Tracking codes: Tracking code is pas actief als het veld ingevuld. Vul alleen de ID in.</p>
           
				<?php
				
                    settings_fields( 'digiflow_settings_option_group' );
                    do_settings_sections( 'digiflow-settings-admin' );
					
					submit_button();
				?>
			</form>
		</div>
	<?php }

public function digiflow_settings_page_init() {
    register_setting(
        'digiflow_settings_option_group', // option_group
        'digiflow_settings_option_name', // option_name
        array( $this, 'digiflow_settings_sanitize' ) // sanitize_callback
    );

    add_settings_section(
        'digiflow_settings_setting_section', // id
        'Settings', // title
        array( $this, 'digiflow_settings_section_info' ), // callback
        'digiflow-settings-admin' // page
    );

    add_settings_field(
        'cookienotice_toggle', // id
        'Cookiemelding', // title
        array( $this, 'cookienotice_toggle_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'google_analytics_tracking_id_0', // id
        'Google analytics tracking id', // title
        array( $this, 'google_analytics_tracking_id_0_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'facebook_pixel_tracking_id_1', // id
        'Facebook pixel tracking id', // title
        array( $this, 'facebook_pixel_tracking_id_1_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'bing_tracking_id_2', // id
        'Bing tracking id', // title
        array( $this, 'bing_tracking_id_2_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'optimize_tracking_id_3', // id
        'Optimize tracking id', // title
        array( $this, 'optimize_tracking_id_3_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'hotjar_tracking_id_4', // id
        'Hotjar tracking id', // title
        array( $this, 'hotjar_tracking_id_4_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'fb_chat_id_5', // id
        'Fb chat id', // title
        array( $this, 'fb_chat_id_5_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'fb_chat_color_6', // id
        'Fb chat color', // title
        array( $this, 'fb_chat_color_6_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    

    add_settings_field(
        'company_name', // id
        'Company Name', // title
        array( $this, 'company_name_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'company_mail', // id
        'Company Mail', // title
        array( $this, 'company_mail_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );

    add_settings_field(
        'company_address', // id
        'Company Address', // title
        array( $this, 'company_address_callback' ), // callback
        'digiflow-settings-admin', // page
        'digiflow_settings_setting_section' // section
    );
}

public function digiflow_settings_sanitize($input) {
    $sanitary_values = array();
    
    if ( isset( $input['cookienotice_toggle'] ) ) {
        $sanitary_values['cookienotice_toggle'] = sanitize_text_field( $input['cookienotice_toggle'] );
    }

    if ( isset( $input['google_analytics_tracking_id_0'] ) ) {
        $sanitary_values['google_analytics_tracking_id_0'] = sanitize_text_field( $input['google_analytics_tracking_id_0'] );
    }

    if ( isset( $input['facebook_pixel_tracking_id_1'] ) ) {
        $sanitary_values['facebook_pixel_tracking_id_1'] = sanitize_text_field( $input['facebook_pixel_tracking_id_1'] );
    }

    if ( isset( $input['bing_tracking_id_2'] ) ) {
        $sanitary_values['bing_tracking_id_2'] = sanitize_text_field( $input['bing_tracking_id_2'] );
    }

    if ( isset( $input['optimize_tracking_id_3'] ) ) {
        $sanitary_values['optimize_tracking_id_3'] = sanitize_text_field( $input['optimize_tracking_id_3'] );
    }

    if ( isset( $input['hotjar_tracking_id_4'] ) ) {
        $sanitary_values['hotjar_tracking_id_4'] = sanitize_text_field( $input['hotjar_tracking_id_4'] );
    }

    if ( isset( $input['fb_chat_id_5'] ) ) {
        $sanitary_values['fb_chat_id_5'] = sanitize_text_field( $input['fb_chat_id_5'] );
    }

    if ( isset( $input['fb_chat_color_6'] ) ) {
        $sanitary_values['fb_chat_color_6'] = sanitize_text_field( $input['fb_chat_color_6'] );
    }

    if ( isset( $input['company_name'] ) ) {
        $sanitary_values['company_name'] = sanitize_text_field( $input['company_name'] );
    }

    if ( isset( $input['company_mail'] ) ) {
        $sanitary_values['company_mail'] = sanitize_text_field( $input['company_mail'] );
    }

    if ( isset( $input['company_address'] ) ) {
        $sanitary_values['company_address'] = sanitize_text_field( $input['company_address'] );
    }

    return $sanitary_values;
}

public function digiflow_settings_section_info() {
    
}


public function cookienotice_toggle_callback() {
    if($this->digiflow_settings_options['cookienotice_toggle'] == "cookieactief"){
        $cookiechecked = "checked";
    };
    echo('<input type="checkbox" id="cookienotice_toggle" name="digiflow_settings_option_name[cookienotice_toggle]" value="cookieactief" '.$cookiechecked.'><label for="cookienotice_toggle"> Actief</label>');
}


public function google_analytics_tracking_id_0_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[google_analytics_tracking_id_0]" id="google_analytics_tracking_id_0" value="%s" placeholder="UA-XXXXXXXXXX" maxlength="18">',
        isset( $this->digiflow_settings_options['google_analytics_tracking_id_0'] ) ? esc_attr( $this->digiflow_settings_options['google_analytics_tracking_id_0']) : ''
    );
}

public function facebook_pixel_tracking_id_1_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[facebook_pixel_tracking_id_1]" id="facebook_pixel_tracking_id_1" value="%s" placeholder="89000155142XXXX" maxlength="25">',
        isset( $this->digiflow_settings_options['facebook_pixel_tracking_id_1'] ) ? esc_attr( $this->digiflow_settings_options['facebook_pixel_tracking_id_1']) : ''
    );
}

public function bing_tracking_id_2_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[bing_tracking_id_2]" id="bing_tracking_id_2" value="%s" placeholder="?" maxlength="25">',
        isset( $this->digiflow_settings_options['bing_tracking_id_2'] ) ? esc_attr( $this->digiflow_settings_options['bing_tracking_id_2']) : ''
    );
}

public function optimize_tracking_id_3_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[optimize_tracking_id_3]" id="optimize_tracking_id_3" value="%s" placeholder="OPT-MPQ9XXX" maxlength="25">',
        isset( $this->digiflow_settings_options['optimize_tracking_id_3'] ) ? esc_attr( $this->digiflow_settings_options['optimize_tracking_id_3']) : ''
    );
}

public function hotjar_tracking_id_4_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[hotjar_tracking_id_4]" id="hotjar_tracking_id_4" value="%s" placeholder="1502XXX" maxlength="25">',
        isset( $this->digiflow_settings_options['hotjar_tracking_id_4'] ) ? esc_attr( $this->digiflow_settings_options['hotjar_tracking_id_4']) : ''
    );
}

public function fb_chat_id_5_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[fb_chat_id_5]" id="fb_chat_id_5" value="%s" placeholder="226563975351XXXX" maxlength="25">',
        isset( $this->digiflow_settings_options['fb_chat_id_5'] ) ? esc_attr( $this->digiflow_settings_options['fb_chat_id_5']) : ''
    );
}

public function fb_chat_color_6_callback() {
    printf(
        '<input class="regular-text" type="color" name="digiflow_settings_option_name[fb_chat_color_6]" id="fb_chat_color_6" value="%s">',
        isset( $this->digiflow_settings_options['fb_chat_color_6'] ) ? esc_attr( $this->digiflow_settings_options['fb_chat_color_6']) : ''
    );
}
public function company_name_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[company_name]" id="company_name" value="%s">',
        isset( $this->digiflow_settings_options['company_name'] ) ? esc_attr( $this->digiflow_settings_options['company_name']) : ''
    );
}
public function company_mail_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[company_mail]" id="company_mail" value="%s">',
        isset( $this->digiflow_settings_options['company_mail'] ) ? esc_attr( $this->digiflow_settings_options['company_mail']) : ''
    );
}
public function company_address_callback() {
    printf(
        '<input class="regular-text" type="text" name="digiflow_settings_option_name[company_address]" id="company_address" value="%s">',
        isset( $this->digiflow_settings_options['company_address'] ) ? esc_attr( $this->digiflow_settings_options['company_address']) : ''
    );
}



}
if ( is_admin() )
	$digiflow_settings = new DigiflowSettings();

/* 
 * Retrieve this value with:
 * $digiflow_settings_options = get_option( 'digiflow_settings_option_name' ); // Array of All Options
 * $google_analytics_tracking_id_0 = $digiflow_settings_options['google_analytics_tracking_id_0']; // Google analytics tracking id
 * $facebook_pixel_tracking_id_1 = $digiflow_settings_options['facebook_pixel_tracking_id_1']; // Facebook pixel tracking id
 * $bing_tracking_id_2 = $digiflow_settings_options['bing_tracking_id_2']; // Bing tracking id
 * $optimize_tracking_id_3 = $digiflow_settings_options['optimize_tracking_id_3']; // Optimize tracking id
 * $hotjar_tracking_id_4 = $digiflow_settings_options['hotjar_tracking_id_4']; // Hotjar tracking id
 * $fb_chat_id_5 = $digiflow_settings_options['fb_chat_id_5']; // Fb chat id
 * $fb_chat_color_6 = $digiflow_settings_options['fb_chat_color_6']; // Fb chat color
 */