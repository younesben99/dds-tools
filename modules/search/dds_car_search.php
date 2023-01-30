<?php



add_shortcode('dds_car_search', 'dds_car_search_function');


function dds_car_search_function($atts, $content = null) {


    $args =  array(
            'post_type'      => 'autos', 
            'post_status'    => 'published', 
            'posts_per_page' => -1,
            'meta_key'   => '_car_post_status_key',
            'meta_value' => 'actief'
        );
    $cars = get_posts( $args );
    
    $carcount = 0;
    foreach ($cars as $value) {
      $carcount++;
    }

    $posts = get_posts( 
        array(
            'post_type'      => 'autos', 
            'post_status'    => 'published', 
            'posts_per_page' => -1,
            'meta_key'   => '_car_post_status_key',
            'meta_value' => 'actief'
        ) 
    );

    $merken = array();
  

    $merkenoptions = array();
  

    foreach($posts as $post){
         $merk = get_post_meta( $post->ID, '_car_merkcf_key', true );
         array_push($merken,$merk);

    }

    $merken = array_unique($merken);
  

   

    foreach ($merken as $merk) {
        $merk = "<option value='".slugify($merk)."'>".$merk."</option>";
        array_push($merkenoptions,$merk);
    }



    ?>

<style>
   .dds_car_search {
    width: 250px;
    height: 160px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
}
#dds_car_search_submit{cursor:pointer !important;}
</style>
<div class="dds_car_search">

<select name="dds_car_search_merk" id="dds_car_search_merk">
    <option value="select" class="dds_car_search_select" selected>Kies merk</option>

    <?php

    foreach($merkenoptions as $merk){
        echo($merk);
    }

?>

</select>
<select name="dds_car_search_model" id="dds_car_search_model" >
    <option value="select" disabled="disabled" class="dds_car_search_select" selected>Kies model</option>
  
</select>
<button id="dds_car_search_submit"><i class='fas fa-search' style='margin-right:5px;'></i>Bekijk aanbod (<span id="search_carcount"><?php echo($carcount) ?></span>)</button>

</div>




    <?php
  
    return $dds_car_search;
}


?>