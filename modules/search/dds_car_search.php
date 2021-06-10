<?php



add_shortcode('dds_car_search', 'dds_car_search_function');




function dds_car_search_function($atts, $content = null) {

   
    $dds_atts = shortcode_atts( array(
		'direction' => 'col',
        'height' => 'unset'
	), $atts );


    global $post;
    $merken_array = array();
    $modellen_array = array();
    $loop = new WP_Query(array('post_type' => 'autos', 'posts_per_page' => -1));
    while ($loop->have_posts()) : $loop->the_post();

    //actieve merken en modellen ophalen
    $post_memo = wp_get_post_terms($post->ID, 'merkenmodel');
    
    foreach ($post_memo as $v) {
    
        
        if($v->parent == 0){
            $merken_array[$v->term_id] = array("term_id" => $v->term_id,"name" => $v->name,"slug" => $v->slug);
        }
        else{
            $modellen_array[$v->term_id] = array("term_id" => $v->term_id,"name" => $v->name,"slug" => $v->slug,"parent" => $v->parent);
        }
        
        
    }
    endwhile;
    wp_reset_query();
    foreach ($merken_array as $s) {
        
        $merkoptions .= "<option data-term-id='".$s["term_id"]."' data-slug='".$s["slug"]."'>" . $s["name"] . "</option>";

    }


    foreach ($modellen_array as $s) {
        
        $modellenoptions .= "<option style='display:none;' data-term-id='".$s["term_id"]."' data-slug='".$s["slug"]."'  data-parent-id='".$s["parent"]."'>" . $s["name"] . "</option>";

    }

    wp_enqueue_style( 'dds_car_search_module', get_site_url() . '/wp-content/plugins/dds-tools/assets/css/dds_car_search.css?v=22' );
    wp_enqueue_script(
        'dds_car_search_module', 
        get_site_url() . '/wp-content/plugins/dds-tools/assets/js/dds_car_search.js', 
        array( 'jquery' ), 
        false, 
        true 
    );


    if($dds_atts["direction"] == "col"){
        $dds_search_direction = "dds_car_search_inner_col";
        $dds_search_direction_wrap = "dds_car_search_wrap_col";
    }
    else{
        $dds_search_direction = "dds_car_search_inner_row";
        $dds_search_direction_wrap = "dds_car_search_wrap_row";
    }
    

    if($dds_atts["height"] !== "unset"){
        $dds_search_height = $dds_atts["height"];
    }
    

    $dds_car_search .= "<div class='".$dds_search_direction_wrap."' style='height:".$dds_search_height.";'>";
    $dds_car_search .= "<div class='".$dds_search_direction."'>";

    $dds_car_search .= "<select class='dds_car_search_merk'>";

    $dds_car_search .= "<option>Kies een merk</option>";

    $dds_car_search .= $merkoptions;

    $dds_car_search .= "</select>";

    $dds_car_search .= "<select class='dds_car_search_model' disabled>";

    $dds_car_search .= "<option class='dds_car_search_choose_model'>Kies een model</option>";

    $dds_car_search .= $modellenoptions;

    $dds_car_search .= "</select>";


    $dds_car_search .= "<button type='submit' class='dds_car_search_submit elementor-button'>Zoeken</button>";


  


    $dds_car_search .= "</div>";
    $dds_car_search .= "</div>";

    return $dds_car_search;
}


?>