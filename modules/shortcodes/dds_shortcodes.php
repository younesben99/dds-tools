<?php


function prefix_query_args( $query_args, $grid_id ) {

    $carousel_cars = get_option("uitgelichtewagens");
    $dds_settings_options = get_option( 'dds_settings_option_name' ); 

    $carousel_grid_id = $dds_settings_options['carousel_grid_id'];
    
    if(!empty($carousel_grid_id) && !empty($carousel_cars)){
        if ( $carousel_grid_id == $grid_id ) {
            $query_args['post__in'] = $carousel_cars;
        }
    }
	

	return $query_args;

}

add_filter( 'wp_grid_builder/grid/query_args', 'prefix_query_args', 10, 2 );


function dds_uitgelichte_wagens( $atts ){

    $grid_id = $atts["id"];

    if(empty($grid_id)){
        $grid_id = 1;
    }

	wpgb_render_grid(
        [
            'id' => $grid_id
        ]
    );

    $carousel_cars = get_option("uitgelichtewagens");
        
    var_dump($carousel_cars);

    

    

}
add_shortcode( 'dds_uitgelichte_wagens', 'dds_uitgelichte_wagens' );



?>