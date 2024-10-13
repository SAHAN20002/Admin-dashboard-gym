<?php
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'phpcon.php';
session_start();

if (!isset($_SESSION['admin_Id'])) {
    header('location:index.php');
    exit();
  }else{
    
   
    $ID = $_SESSION['admin_Id'] ;
   
    if(isset($_POST['password'])){
        $password = $_POST['password'];
        $sql = "SELECT * FROM admin WHERE admin_Id  = '$ID'";
        $result = $conn->query($sql);
        if($result->num_rows > 0){
            $row = $result->fetch_assoc();
            if ($password === $row['Password']) {
                echo "<script>alert('Password is correct');</script>";
                
                header('location:deleteinstructor.php');
            }else{
                echo "<script>alert('Password is incorrect');</script>";
                
            }
        }else{
            echo "<script>alert('No user found');</script>";
        }
    }   
  }


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            height: 150px;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .container h2 {
            margin-bottom: 20px;
        }
        .container input[type="password"] {
            width: 90%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .container input[type="submit"] {
            width: 95%;
            padding: 10px;
            background-color: #28a745;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        .container input[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Password Check</h2>
        <form action="instructorDeletePaswordChk.php" method="post">
            <input type="password" name="password" placeholder="Enter your password" required>
            <input type="submit" value="Check Password">
        </form>
    </div>
</body>
</html>