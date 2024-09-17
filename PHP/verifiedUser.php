<?php 
include 'phpcon.php';

// Get the user ID from the request

if(isset($_POST['userId'])){
    $userId = $_POST['userId'];
    $sql = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $updateSql = "UPDATE users SET membership_status = 1 WHERE user_id = '$userId'";
        if ($conn->query($updateSql) === TRUE) {
            $response = array( 'message' => 'Membership status updated.');
        } else {
            $response = array( 'error' => 'Error updating membership status.');
        }
        echo json_encode($response);
    }else{
        $response = array('error' => 'No user found.');
        echo json_encode($response);
    }   
}else{
    $response = array( 'error' => 'No user ID provided.');
    echo json_encode($response);
}


?>