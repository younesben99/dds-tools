<?php


if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    include(__DIR__."/../../../../../wp-load.php");


$carcount = 0;

$posts = get_posts( 
    array(
        'post_type'      => 'autos', 
        'post_status'    => 'published', 
        'posts_per_page' => -1,
        'meta_key'   => '_car_post_status_key',
        'meta_value' => 'actief'
    ) 
);
foreach ($posts as $value) {
    $carcount++;
  }

$modellen = array();


$modellenoptions = array(
    "<option value='select' disabled='disabled' class='dds_car_search_select' selected>Kies model</option>"
);

foreach($posts as $post){
   
     $merk = get_post_meta( $post->ID, '_car_merkcf_key', true );
     $model = get_post_meta( $post->ID, '_car_modelcf_key', true );
 
     if(slugify($merk) == $_POST["merk"]){
       
        array_push($modellen,array(
            "merk" => $_POST["merk"],
            "model" => $model
         ));
        }
     

    
}










foreach ($modellen as $model) {

    if(!empty($model["model"])){
        $model = "<option data-merk='".slugify($model["merk"])."' value='".slugify($model["model"])."'>".$model["model"]."</option>";
        array_push($modellenoptions,$model);
    }
       

}
$model_count = count($modellenoptions);
$modellenoptions = array_unique($modellenoptions);

echo(json_encode([$modellenoptions,$model_count]));


}
?>