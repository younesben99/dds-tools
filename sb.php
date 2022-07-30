<?php

include(__DIR__."/../../../wp-load.php");


// function iterate_dir($path) {
//     $files = array( );
//     if (is_dir($path) & is_readable($path)) {
//         $dir = dir($path);
//         while (false !== ($file = $dir->read( ))) {
//             // skip . and .. 
//             if (('.' == $file) || ('..' == $file)) {
//                 continue;
//             }
//             if (is_dir("$path/$file")) {
//                 $files = array_merge($files, iterate_dir("$path/$file"));
//             } else {
//                 array_push($files, $file);

//                 if(
//                     strpos($file,"225x") ||
//                      strpos($file,"768x") || 
//                      strpos($file,"1024x")|| 
//                      strpos($file,"150x")
//                      ){
//                        //unlink ($path."/".$file);
                       
                       
//                    }
              
//             }
//         }
//         $dir->close( );
//     } 
//     return $files;
// }




// $files = iterate_dir(__DIR__."/../../uploads/2022_fa/");
// $counter1 = 0;
// $counter2 = 0;
// $counter3 = 0;
// foreach($files as $file){
//     $counter3++;
    
//     if(
//         strpos($file,"225x") ||
//          strpos($file,"768x") || 
//          strpos($file,"1024x")
//          ){
           
//            $counter1++;
         
//        }
//        else{
//         if($counter2 < 2100){
//           //  var_dump($file);
//         }
       
//            $counter2++;
//        }
// }
// echo("totaal: ".$counter3." innodes<br>");
// echo("behoud: ".$counter2."<br>");
// echo("verwijder: ".$counter1 . "<hr>");



