<?php 
include 'phpcon.php';
include 'mailsend.php';


// Get the user ID from the request

if(isset($_POST['userId'])){
    $userId = $_POST['userId'];
    $sql = "SELECT * FROM users WHERE user_id = '$userId'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $updateSql = "UPDATE users SET membership_status = 1 WHERE user_id = '$userId'";
        if ($conn->query($updateSql) === TRUE) {

           
            $to = $row['email'];
            $subject = "Membership Verified";
            $message = "Your Paymnet has been verified. Your membership has been activated.";
            $Heder = "From: Fitness Zone";
            mailsend($to, $subject, $message, $Heder);
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