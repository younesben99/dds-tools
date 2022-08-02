<?php

include(__DIR__."/../../../wp-load.php");











//wp media library


$ids = get_posts( 
    array(
        'post_type'      => 'autos', 
        'post_status'    => 'any', 
        'posts_per_page' => -1,
    ) 
);
$images = array();
$counter1 = 0;

foreach ( $ids as $id ){
    $post_status = get_post_meta( $id->ID, '_car_post_status_key', true );
    $gal = get_post_meta( $id->ID, 'vdw_gallery_id', true );
   
    if($post_status == "archief"){
        
      
        for ($i=1; $i < count($gal); $i++) { 
        
             wp_delete_attachment($gal[$i]);

             $counter1++;
          
        }
       
    }
   
}
echo("totaal: ".$counter1." verwijderd<br>");

//verwijder van archief autos alle fotos behalve de eerste
