<?php 
session_start();
include 'phpcon.php';
if(isset($_POST['userId'])){
    $userId = $_POST['userId'];
    $sql = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $updateSql = "DELETE FROM users WHERE user_id = '$userId'";
           if( $conn->query($updateSql)){

             $response = array( 'message' => 'user delete.');
             echo json_encode($response);
                 
            } else {
               $response = array( 'error' => 'Error updating membership status.');
               echo json_encode($response);
            }            
    }else{
        $response = array('error' => 'No user found.');
        echo json_encode($response);
    }   
}else{
    $response = array( 'error' => 'No user ID provided.');
    echo json_encode($response);
}    
?>