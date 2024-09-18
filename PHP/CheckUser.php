<?php 
include 'phpcon.php';
session_start();
if (!isset($_SESSION['admin_Id'])) {
  header('location:index.php');
}

$useremailVerificationStatus = 0;
$userMembershipStatusDisplay = "No";
$userInstructorStatusDisply = "No";

    $userId = "null";
    $useremailVerificationStatus = "null";
    $username_1 = "null";
    $useremail = "null";
    $usernic = "null";
    $userGendr = "null";
    $userpaymnetSlipPhoto = "null";
    $userInstructorSlup = "null";
    $userMembershipStatus = "null";
    $userInstructorStatus = "null";
    $userPhonenumber = "null";
    $userAge = "null";
    $membership = "null";
    $instrcutor = "null";

if (isset($_GET['cancel']) && $_GET['cancel'] === 'true') {
    $userId = "null";
    $useremailVerificationStatus = "null";
    $username_1 = "null";
    $useremail = "null";
    $usernic = "null";
    $userGendr = "null";
    $userpaymnetSlipPhoto = "null";
    $userInstructorSlup = "null";
    $userMembershipStatus = "null";
    $userInstructorStatus = "null";
    $userPhonenumber = "null";
    $userAge = "null";
    $membership = "null";
    $instrcutor = "null";
}else{
  $nic = isset($_GET['nic']) ? $_GET['nic'] : null;
  // Assuming you have a database connection in 'phpcon.php'
  $stmt = $conn->prepare("SELECT * FROM users WHERE NIC = ?");
  $stmt->bind_param("s", $nic);
  $stmt->execute();
  $result = $stmt->get_result();

  if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $userId = $user['user_id'];
    $useremailVerificationStatus = $user['email_v_status'];
    $username_1 = $user['user_name'];
    $useremail = $user['email'];
    $usernic = $user['NIC'];
    $userGendr = $user['gender'];
    $userpaymnetSlipPhoto = $user['payment_slip'];
    $userInstructorSlup = $user['instructor_pyamnet_slip'];
    $userMembershipStatus = $user['membership_status'];
    $userInstructorStatus = $user['instructor_status'];
    $userPhonenumber = $user['p_number'];
    $userAge = $user['age'];
    $membership = $user['membership_plan'];
    $instrcutor = $user['instructor'];
    
    if ($userMembershipStatus == '1') {
      $userMembershipStatusDisplay = "success";
    }
    if ($userInstructorStatus == '1') {
      $userInstructorStatusDisply = "success";
    } 
    if($userpaymnetSlipPhoto == 'null'){
      $userpaymnetSlipPhoto = "http://localhost/sahan/admin-main/IMG/No_slip.png";
    }
    if($userInstructorSlup == 'null'){
      $userInstructorSlup = "http://localhost/sahan/admin-main/IMG/No_slip.png";
    }

    
    // echo $userInstructorSlup;
    // You can now use $user['column_name'] to display user information
  } else {
    // echo '<h3 style="text-align:center">No user in database</h3>';
  }
}

if(isset($_POST['cansel'])){
  $userId = "null";
  $useremailVerificationStatus = "null";
  $username_1 = "null";
  $useremail = "null";
  $usernic = "null";
  $userGendr = "null";
  $userpaymnetSlipPhoto = "null";
  $userInstructorSlup = "null";
  $userMembershipStatus = "null";
  $userInstructorStatus = "null";
  $userPhonenumber = "null";
  $userAge = "null";
  $membership = "null";
  $instrcutor = "null";
}


?>





<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verifications Membership</title>
  
  <style>
    tbody::-webkit-scrollbar {
      width: 5px;
     
    }

   
    tbody::-webkit-scrollbar-thumb {
      background-color: #d70e0e;
      
      border-radius: 10px;
      
      border: 2px solid #f1f1f1;
      
    }

   
    tbody::-webkit-scrollbar-thumb:hover {
      background-color: #555;
      
    }

    
    tbody::-webkit-scrollbar-track {
      background-color: #090202;
      
    }


    .search-bar {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 20px;
    }

    .search-bar input[type="text"] {
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-right: 10px;
      width: 300px;
    }

    .search-bar button {
      padding: 10px 20px;
      font-size: 16px;
      border: none;
      border-radius: 4px;
      background-color: #007BFF;
      color: white;
      cursor: pointer;
      margin: 3px;
    }

    .search-bar button:hover {
      background-color: #0056b3;
    }

    
    body {
      font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      background-image: url(../IMG/bg.jpg);
      background-size: cover;
    }

    .dashboard {
      max-width: 1200px;
      margin: auto;
      padding: 20px;
    }

    header {
      text-align: center;
      margin-bottom: 20px;
      color: azure;
    }

    main {
      display: flex;
      flex-direction: column;
      color: #ffffff;
    }

    .show_info {
      width: 100%;
      height: 500px;
      
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;

    }



    @media (max-width: 480px) {
      .dashboard {
        padding: 10px;
      }


    }


    #back-button {
      background-color: #0088ff;
      color: #000000;
      border: none;
      border-radius: 5px;
      padding: 10px 30px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
      margin-bottom: 20px;
      margin-top: -20px;
      margin-left: -80px;
    }



    #back-button:hover {
      background-color: #ffe600;
    }


    #back-button:focus {
      outline: 2px solid #b3a700;
      outline-offset: 2px;
    }

    h3 {
      color: white;
      padding: -5px;
    }

    .show_info_inner_1 {
      width: 30%;
      height: 100%;
      /* border: 1px solid red; */
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .show_info_inner_2 {
      width: 50%;
      height: 90%;
      /* border: 1px solid red; */
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      
    }
    .show_info_inner_3 {
      width: 50%;
      height: 90%;
      /* border: 1px solid red; */
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      
    }
  </style>
  <script>
  function resetVariables(){
    document.getElementById('cancel').value='true';
  }
 </script>
 
</head>

<body>



  <div class="dashboard" id="body">

    <header>
      <h1>Check Users</h1>
    </header>
    <button id="back-button" onclick="window.location.href='DashBoard.php'">Back</button>

    <main>
      <div class="search-bar">
      <form action="CheckUser.php" method="GET"> 
        <input type="text" name="nic" placeholder="Enter the NIC" >
        <input type="hidden" name="cancel" id="cancel" value="false">
        <button type="submit">Search</button>
        <button type="submit" onclick="resetVariables()">Cancel</button>
      </form>   
      
      </div>
      <?php 
      
      if($userId != "null"){
      echo '
      <div class="show_info">
        <div class="show_info_inner_1">
          <div>
            <h3>User Id : '.$userId.'</h3>
            <h3>User Name : '.$username_1.'</h3>
            <h3>Email : '.$useremail.'</h3>
            <h3>NIC : '.$usernic.'</h3>
            <h3>Phone number : '.$userPhonenumber.'</h3>
            <h3>Gender : '.$userGendr.'</h3>
            <h3>Membership Status : '.$userMembershipStatusDisplay.'</h3>
            <h3>Membership : '.$membership.'</h3>
            <h3>Instrcutors : '.$instrcutor.'</h3>
            <h3>Instrcutors Status : '.$userInstructorStatusDisply.'</h3>
          </div>
        </div>
        <div class="show_info_inner_2">
          <h3>Membership Paymnet Slip</h3>
          <img style="width: 90%; height: 90%; border: 1px solid white; border-radius: 20px;" src="'.$userpaymnetSlipPhoto.'" alt="">
        </div>
        <div class="show_info_inner_3">
          <h3>Instrcutors Paymnet Slip</h3>
          <img style="width: 90%; height: 90%; border: 1px solid white; border-radius: 20px;" src="'.$userInstructorSlup.'" alt="">
        </div>

      </div>
      ';
      }else{
        echo '<h3 style="text-align:center">No user in database</h3>';
      }
      
      ?>

    </main>
  </div>
 
</body>

</html>