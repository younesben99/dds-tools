<?php

function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }

    array_multisort($sort_col, $dir, $arr);
}

$json = json_decode(file_get_contents(__DIR__."/assets/modellen.json"),true);


foreach ($json as $value) {
    if($value["makeId"] == 47){
        var_dump($value);
    }

}

if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {

    $merkid = $_POST["merkid"];

    $json = json_decode(file_get_contents(__DIR__."/assets/modellen.json"),true);

    $sortingnames = array();
    

    foreach($json as $value){
        if($value["makeId"] == $merkid){
            array_push($sortingnames,$value);
        }
        
    }

    
    
    array_sort_by_column($sortingnames, 'name');


    foreach($sortingnames as $value){
        if($value["makeId"] == $merkid){
            $option .= "<option data-parent='".$value["makeId"]."' value='".$value["name"]."'>".$value["name"]."</option>";
        }
        
    }

    echo($option);


}

?>