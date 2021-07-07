<?php

if(isset($_POST['dropzone_map'])){


    $dropzonemap = __DIR__."/uploads/".$_POST['dropzone_map'];

    if (!is_dir($dropzonemap)) {
        mkdir($dropzonemap, 0777, true);
    }

    if (!empty($_FILES['file']['name'])) {
	
        $file_name = "";
    
        $totalFile = count($_FILES['file']['name']);
    
        for ($i=0; $i < $totalFile ; $i++) {
    
            $fileName = $_FILES['file']['name'][$i]; 
            $extension = pathinfo($fileName, PATHINFO_EXTENSION);
            $allowExtn = array('png', 'jpeg', 'jpg');
    
            if (in_array($extension, $allowExtn)) {
            $newName = rand() . ".". $extension;
            $uploadFilePath = $dropzonemap."/".$newName;
            move_uploaded_file($_FILES['file']['tmp_name'][$i], $uploadFilePath);
            $file_name .= $newName ." , ";				
            }
        }
        
    }
}




?>