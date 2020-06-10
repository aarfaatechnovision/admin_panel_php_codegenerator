<?php

include('../include/dbcon.php');




//copy callback_functions 

$dir1 = "../callback_functions";
if( is_dir($dir1) === false )
{
    mkdir($dir1);
}

  
$src1 = "callback_functions"; 
  
$dst1 = "../callback_functions"; 
  
custom_copy($src1, $dst1); 







$dirs1 = "../src";
if( is_dir($dirs1) === false )
{
    mkdir($dirs1);
}

  
$srcs1 = "src"; 
  
$dsts1 = "../src"; 
  
custom_copy($srcs1, $dsts1); 






$dire1 = "../vendors";
if( is_dir($dire1) === false )
{
    mkdir($dire1);
}

  
$srce1 = "vendors"; 
  
$dste1 = "../vendors"; 
  
custom_copy($srce1, $dste1); 

















function custom_copy($src, $dst) {  
  
    // open the source directory 
    $dir = opendir($src);  
  
    // Make the destination directory if not exist 
    @mkdir($dst);  
  
    // Loop through the files in source directory 
    while( $file = readdir($dir) ) {  
  
        if (( $file != '.' ) && ( $file != '..' )) {  
            if ( is_dir($src . '/' . $file) )  
            {  
  
                // Recursively calling custom copy function 
                // for sub directory  
                custom_copy($src . '/' . $file, $dst . '/' . $file);  
  
            }  
            else {  
                copy($src . '/' . $file, $dst . '/' . $file);  
            }  
        }  
    }  
  
    closedir($dir); 
}  





  


header("Location: p1.php");


?>