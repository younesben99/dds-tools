<?php

function unique_multidim_array($array, $key) { 
    $temp_array = array(); 
    $i = 0; 
    $key_array = array(); 
    
    foreach($array as $val) { 
        if (!in_array($val[$key], $key_array)) { 
            $key_array[$i] = $val[$key]; 
            $temp_array[$i] = $val; 
        } 
        $i++; 
    } 
    return $temp_array; 
  }
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


function dds_aankoop_makes_list( $atts ){

    $output;
    $args = shortcode_atts( 
        array(
            'id'   => ''
        ), 
        $atts
    );


    if(!isset( $atts["id"])){
        return("geen parent id");
    }
    else{

        $parent_id = $atts["id"];
     

        $args = array(
            'post_type'      => 'page',
            'posts_per_page' => -1,
            'post_parent'    => $parent_id,
            'order'          => 'ASC',
            'orderby'        => 'menu_order'
         );
        
        
        $parent = new WP_Query( $args );
        $makes = array();

        while( $parent->have_posts() ) {

            $post = $parent->the_post();

            $make["name"] = ucwords(get_post_meta(get_the_ID($post),"autoverkopen_merk", true));
            $make["url"] = get_permalink($post);

            array_push($makes,$make);
           
            
           
        }

        wp_reset_postdata();
        

       
        
        $makes = unique_multidim_array($makes,"name");
        
       
        sort($makes);
       
        $previousLetter = null;
        $output .= "<style>
        .dds_aankoop_make_col{
            width: 25%;
            padding-bottom: 36px;
            margin-bottom: 28px;
            border-bottom: 1px solid #f3f3f3;
        }
        .dds_aankoop_make_col a{
            color: #2f2f2f;
            font-weight: 400;
            font-size: 14px;
            }
        @media only screen and (max-width: 500px) {
            .dds_aankoop_make_col{
                width:50%;
                }
          }
        </style>
        <div style='display: flex;flex-wrap: wrap;'><div>";

        foreach($makes as $make){
        
            
            if(!empty($make["name"])){
                $firstLetter = substr($make["name"], 0, 1);
                if($previous !== $firstLetter){
                   $output .= "</div><div class='dds_aankoop_make_col'><h2>".$firstLetter."</h2>";
                }

                $output .=  "<a href='".$make["url"]."'>".$make["name"]."</a><br>";
               
            }
        
        $previous = $firstLetter;
        }
        $output .= "</div></div>";
        
        

    }
    
    return($output);
}
add_shortcode( 'dds_aankoop_makes_list', 'dds_aankoop_makes_list' );



?>