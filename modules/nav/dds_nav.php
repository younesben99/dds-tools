<?php

class DDS_Custom_Walker_Nav_Menu extends Walker_Nav_Menu {
    private $active;

    public function __construct( $active ) {
        $this->active = $active;
    }

    public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
        if ( $item->menu_order == $this->active ) {
            $item->classes[] = 'dds_li_active';
        }

        parent::start_el( $output, $item, $depth, $args, $id );
    }
}
function dds_add_custom_html_to_menu( $items, $args ) {
    if ( isset($args->custom_html) && !empty($args->custom_html) ) {
        // Process and append custom HTML to the menu items
        $custom_html = do_shortcode($args->custom_html);
        $items .= '<li class="menu-item custom-html custom-html-mobile">' . $custom_html . '</li>';
    }
    return $items;
}
add_filter( 'wp_nav_menu_items', 'dds_add_custom_html_to_menu', 10, 2 );


function dds_nav( $atts ) {
    $atts = shortcode_atts( array(
        'menu' => 'menu',
        'active' => null,
        'custom_html' => '', // Add custom HTML attribute
    ), $atts );

    $walker = null;

    if ( $atts['active'] !== null && is_numeric( $atts['active'] ) ) {
        $walker = new DDS_Custom_Walker_Nav_Menu( $atts['active'] );
    }

    $menu = wp_nav_menu( array(
        'menu'           => $atts['menu'],
        'container'      => 'nav',
        'container_class'=> 'dds-main-nav',
        'menu_class'     => 'navigation-menu',
        'echo'           => false,
        'walker'         => $walker,
        'custom_html'    => $atts['custom_html']
    ) );

    // Add burger menu toggle button and close button for mobile devices
    $toggle_button = '<div class="burger-menu-toggle" aria-label="Menu" aria-expanded="false"><div></div>
    <div></div>
    <div></div></div>';

 

    // Wrap the menu, toggle button, and close button in a container div
    $menu_html = '<div class="dds-desktop-tablet-menu">'.$menu.'</div><div class="dds-navigation-container">' . $toggle_button . $menu . 
     '</div>';

    return $menu_html;
}
add_shortcode( 'navigation', 'dds_nav' );


function nav_close_button($items, $args) {
    // Append HTML to the menu
    $items .= '<div class="close-menu" aria-label="Close Menu" aria-expanded="false"></div>';
    return $items;
}
add_filter('wp_nav_menu_items', 'nav_close_button', 10, 2);



function footer_notice( $atts ) {
    
    $year = date("Y");
    $domain = $_SERVER['HTTP_HOST'];
    $link = "<a href='https://digiflow.be/'>Digiflow</a>";

    $notice = "<style>
    .footer_notice_wrap {
        font-size: 12px;
        font-weight: 500;
        color: #667;
        padding-bottom: 15px;
    }
    .footer_notice_wrap a {
        font-size: 12px;
        font-weight: bold;
        color: #3e75bb;
    }
    
    </style><div class='footer_notice_wrap'>Copyright © ".$year." ".$domain.". Alle rechten voorbehouden - Website by ".$link."</div>";

    return ($notice);
}
add_shortcode( 'footer_notice', 'footer_notice' );


?>