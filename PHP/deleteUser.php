<?php 
session_start();
include 'phpcon.php';
if(isset($_POST['userId'])){
    $userId = $_POST['userId'];
    $sql = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $updateSql = "UPDATE users SET payment_slip = 'null', membership_plan = 'null' WHERE user_id = '$userId'";
           if( $conn->query($updateSql)=== TRUE){

                 $deleteSql = "DELETE FROM membership_user WHERE user_id = '$userId'";
                 if ($conn->query($deleteSql) === TRUE) {
                    $response = array( 'message' => 'User deleted.');
                  } else {
                     $response = array( 'error' => 'Error deleting user.');
                  }
                    echo json_encode($response);
            } else {
               $response = array( 'error' => 'Error updating membership status.');
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