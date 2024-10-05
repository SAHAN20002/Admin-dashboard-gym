<?php
function saveImage($image) {
   
    $targetDir = "uploads/";

   
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }

   
    $imageName = basename($image['name']);
    $targetFilePath = $targetDir . $imageName;

    
    if (move_uploaded_file($image['tmp_name'], $targetFilePath)) {
        
        return $targetFilePath;
    } else {
        
        return false;
    }
}
?>
