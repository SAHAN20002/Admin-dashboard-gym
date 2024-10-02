<?php
include 'phpcon.php';
session_start();
 $c_date = Date('Y-m-d');
 echo $c_date;
$userInstructorSlipDisply = "http://localhost/sahan/admin-main/IMG/No_slip.png";
$useerInstructorStatusPlanDisplay= '<h3 style="margin-top: -12px; color:red">No Paymnet Slip</h3>';
$unsernotfoundmsg = "No user found";

    $userId = "null";
   
    $username_1 = "null";
    $useremail = "null";
    $usernic = "null";
    $userGendr = "null";
    $stratData = "null";
    $endData = "null";
    $userInstructorSlup = "null";
    $userMembershipStatus = "null";
    $userInstructorStatus = "null";
    $userPhonenumber = "null";
    $userAge = "null";
    $membership = "null";
    $instrcutor = "null";
    $instrcutorCost = "0";




if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    

    $in_Id = $_SESSION['Instrutor_ID'];
    
    // Prepare and execute the query
    $stmt = $conn->prepare("SELECT * FROM users WHERE NIC = ? AND instructor = ?");
    $stmt->bind_param("ss", $nic, $in_Id);
    $stmt->execute();
    $result = $stmt->get_result();

    
    
    // Fetch the user data
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        // Store user data in session or variables to use in HTML
        $userId = $user['user_id'];
       
        $username_1 = $user['user_name'];
        $useremail = $user['email'];
        $usernic = $user['NIC'];
        $userGendr = $user['gender'];
       
        $userInstructorSlup = $user['instructor_pyamnet_slip'];
        $userMembershipStatus = $user['membership_status'];
        $userInstructorStatus = $user['instructor_status'];
        $userPhonenumber = $user['p_number'];
        $userAge = $user['age'];
        $membership = $user['membership_plan'];
        $instrcutor = $user['instructor'];

        if($userInstructorSlup != "null"){
            $userInstructorSlipDisply = $userInstructorSlup;
        }else{
            $userInstructorSlipDisply = "http://localhost/sahan/admin-main/IMG/No_slip.png";
        }
        if($userInstructorStatus == "1"){
            $useerInstructorStatusPlanDisplay = '<h3 style="margin-top: -12px; color:green">Active</h3>';
        }else{
            $useerInstructorStatusPlanDisplay = '<h3 style="margin-top: -12px; color:yellow">No active</h3>';
        }

         if($userId != null){
             $stmt = $conn->prepare("SELECT * FROM instructor_user WHERE user_Id = ?");
             $stmt->bind_param("s", $userId);
             $stmt->execute();
             $result = $stmt->get_result();
             $user = $result->fetch_assoc();
             $instrcutorCost = $user['cost'];
             $stratData = $user['s_date'];
             $endData = $user['e_date'];

             if($endData < $c_date){
                $useerInstructorStatusPlanDisplay = '<h3 style="margin-top: -12px; color:red">expried</h3>';
             }


         }
    } else {
        
    }
    
    $stmt->close();
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
      /* border: 2px solid rgb(0, 0, 0); */
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      color: white;

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
      
      padding: -5px;
    }

    .show_info_inner_1 {
      width: 40%;
      height: 100%;
      /* border: 1px solid red; */
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }

    .show_info_inner_2 {
      width: 50%;
      height: 100%;
      /* border: 1px solid red; */
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
    }
  </style>
 
</head>

<body>



  <div class="dashboard" id="body">

    <header>
      <h1>Check Users</h1>
    </header>
    <button id="back-button" onclick="window.history.back()">Back</button>

    <main>
      <div class="search-bar">
        <form method="POST" action="In_chekUser.php">
            <input type="text" name="nic" placeholder="Enter the NIC" require>
            <button type="submit">Search</button>
            <button type="reset">Cancel</button>
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
            <h3>Gender : '.$userGendr.'</h3>
            <h3>Membership type : '. $membership.'</h3>
            <h3>Phone Number : '.$userPhonenumber.'</h3>
            <h3>Age : '. $userAge.'</h3>
            
            <h3>Start date :'.$stratData.'</h3> 
            <h3>End date : '.$endData.'</h3>   
            <h3>Cost : Rs : '.$instrcutorCost.'.00</h3>            
          </div>
        </div>
       
        <div class="show_info_inner_2">
          <h3>Instrcutors Paymnet Slip</h3>
          <h3 style="margin-top: -2px;">'.$useerInstructorStatusPlanDisplay.'</h3>
          <img style="width: 90%; height: 80%; border: 1px solid rgb(10, 10, 10); border-radius: 20px;" src="'. $userInstructorSlipDisply.'" alt="">
        </div>

      </div>
       ';
      }else{
        echo '<h3 style="text-align:center">'.$unsernotfoundmsg.'</h3>';
      }
        ?>

    </main>
  </div>

</body>

</html>