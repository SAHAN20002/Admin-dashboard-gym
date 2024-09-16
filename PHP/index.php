<?php
session_start();
include 'phpcon.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

  $username = $_POST['username'];
  $password = $_POST['password'];

  if($username == 'admin') {

    $stmt = $conn->prepare("SELECT * FROM admin WHERE user_name = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

      $row = $result->fetch_assoc();
      $_SESSION['admin_Id'] = $row['admin_Id'];
      $_SESSION['user_name'] = $row['user_name'];
          
      header('Location: dashboard.php');
    } else {
      echo "<script>
              document.addEventListener('DOMContentLoaded', function() {
                document.getElementById('error-message').style.display = 'block';
              });
            </script>";
    }
  }else{

    $stmt = $conn->prepare("SELECT * FROM instrutor WHERE NIC  = ? AND Password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {

      $row = $result->fetch_assoc();
      $_SESSION['NIC'] = $row['NIC'];
      $_SESSION['user_Id'] = $row['Instrutor_ID	'];
      $_SESSION['user_name'] = $row['user_name'];
          
      header('Location: ../instructor.html');
    } else {
      echo "<script>
      document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('error-message').style.display = 'block';
       });
      </script>";
      
    }
  }

  
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f4f400;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
      background-image: url(../IMG/bg6.jpg);
      background-repeat: no-repeat;
      background-size: cover;
    }

    .profile {
      display: flex;
      justify-content: center;
      align-items: center;
      margin: 20px 0;
    }

    .profile img {
      width: 700px;
      height: 700px;

    }

    @media (max-width: 768px) {
      .profile img {
        width: 80px;
        height: 80px;
      }
    }


    .login-container {
      background: #ffffff53;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px #ffe600;
      width: 400px;
    }

    h1 {
      text-align: center;
      margin-bottom: 20px;
    }

    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 5px;
    }

    input {
      margin-bottom: 15px;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 3px;
    }

    button {
      background-color: #ffea00;
      color: rgb(0, 0, 0);
      border: none;
      padding: 10px;
      border-radius: 3px;
      cursor: pointer;
    }

    button:hover {
      background-color: #b30000;
      color: azure;
    }
  </style>
</head>

<body>
  <div class="profile">
    <img src="../IMG/gym copy.png" alt="User Profile">
  </div>

  <div class="login-container">
    <h1>Login</h1>
    <form id="loginForm" action="index.php" method="post">
      <label for="username">Username :</label>
      <input type="text" id="username" name="username" required>

      <label for="password">Password:</label>
      <input type="password" id="password" name="password" required>

      <button type="submit">Login</button>
    </form>
    <p id="error-message" style="color: red; display: none;">Invalid username/email or password.</p>
  </div>

  <script src="JS/logdash.js"></script>


</body>

</html>