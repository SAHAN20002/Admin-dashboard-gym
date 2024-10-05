<?php
include 'phpcon.php';
include 'mailsend.php';
session_start();
if(isset($_SESSION['Instrutor_ID'])){
    $Instrutor_ID = $_SESSION['Instrutor_ID'];
    $getInstrutorDetails = "SELECT * FROM instrutor WHERE Instrutor_ID = '$Instrutor_ID'";
    $result = $conn->query($getInstrutorDetails);
    if($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $email_V_code = $row['email_v_code'];
        $email = $row['email'];
        $Nic = $row['NIC'];
        $user_name = $row['user_name'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $code = isset($_POST['code']) ? $_POST['code'] : '';
        
        if($code == $email_V_code){
            $updateEmailVStatus = "UPDATE instrutor SET email_v_status = true WHERE Instrutor_ID = '$Instrutor_ID'";
            if($conn->query($updateEmailVStatus) === TRUE){
                echo "<script>alert('Email verified successfully!');</script>";
                if(isset($_SESSION['admin_Id'])){
                    header('Location: deleteinstructor.php');
                }else{
                    $_SESSION['NIC'] = $Nic;
                    $_SESSION['Instrutor_ID'] = $Instrutor_ID;
                    $_SESSION['user_name'] = $user_name;
                    header('Location: instructor.php');
                }
            }else{
                echo "<script>alert('Failed to verify email.');</script>";
            }
        }else{
            echo "<script>alert('Invalid verification code.');</script>";
            echo "<script>alert('Entered code: $code');</script>";
        }
    } 
    
    if(isset($_POST['resend'])){
        $random_code = rand(1000, 9999);
        $updateEmailVCode = "UPDATE instrutor SET email_v_code = '$random_code' WHERE Instrutor_ID = '$Instrutor_ID'";
        if($conn->query($updateEmailVCode) === TRUE){
            $getInstrutorDetails = "SELECT * FROM instrutor WHERE Instrutor_ID = '$Instrutor_ID'";
            $result = $conn->query($getInstrutorDetails);
            $row = $result->fetch_assoc();
            $email_V_code = $row['email_v_code'];
            $email = $row['email'];
            $subject = "Email Verification Code";
            $message = "Your email verification code is: $email_V_code";
            $headers = "From:";
            if(mailsend($email, $subject, $message, $headers)){
                echo "Email sent successfully.";
            }else{
                echo "Failed to send email.";
            }
        }
        
    }


}

?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verification-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
        .verification-container h2 {
            margin-bottom: 20px;
        }
        .code-input {
            letter-spacing: 10px;
            font-size: 1.5rem;
            text-align: center;
            border-radius: 5px;
        }
        .resend-text {
            margin-top: 10px;
            font-size: 0.9rem;
            text-align: center;
        }
        .resend-btn {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            padding: 0;
        }
        .resend-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verification-container">
            <h2 class="text-center">Verify Your Email</h2>
            <p class="text-center">Please enter the 4-digit code sent to your email address.</p>
            <form method="POST" action="email_v.php">
                <div class="mb-4 text-center">
                    <input type="text" class="form-control code-input" id="code" name="code" maxlength="4" placeholder="____" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify Code</button>
            </form>
            <div class="resend-text">
                Didn’t receive the code? <button class="resend-btn" onclick="resendCode()">Resend</button>
            </div>
        </div>
    </div>

    <script>
        function resendCode() {
            fetch('email_v.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'resend=true'
            })
            .then(response => response.text())
            .then(data => {
                alert('Verification code resent successfully.');
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Failed to resend verification code.');
            });
            
        }
    </script>
</body>
</html>
