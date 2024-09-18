<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
include 'phpcon.php';

session_start();
if (!isset($_SESSION['Password'])) {
  header('location:index.php');
}



?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- Include Flatpickr CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
   <script>window.history.replaceState(null, null, window.location.href);</script>
  <!-- Include Flatpickr JS -->
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

  <title>Verifications Membership</title>
  <!-- <link rel="stylesheet" href="appoinment.css"> -->
  <style>
    tbody::-webkit-scrollbar {
      width: 5px;
      /* Width of the scrollbar */
    }

    /* Scrollbar Handle */
    tbody::-webkit-scrollbar-thumb {
      background-color: #d70e0e;
      /* Scrollbar color */
      border-radius: 10px;
      /* Round edges */
      border: 2px solid #f1f1f1;
      /* Padding around scrollbar */
    }

    /* Scrollbar Handle on Hover */
    tbody::-webkit-scrollbar-thumb:hover {
      background-color: #555;
      /* Darker color on hover */
    }

    /* Scrollbar Track */
    tbody::-webkit-scrollbar-track {
      background-color: #090202;
      /* Track color */
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

    /* Base Styles */
    body {
      font-family: Arial, sans-serif;
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

    section {
      margin-bottom: 20px;
      color: #ffffff;
    }

    /* Table Styles */
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 20px;
    }

    table,
    th,
    td {
      border: 1px solid #ddd;
    }

    th,
    td {
      border: 1px solid #db0707;
      padding: 10px;
      text-align: left;
    }

    th {
      background-color: #776a07;
    }

    button {
      background-color: #007bff;
      color: white;
      border: none;
      padding: 5px 10px;
      border-radius: 5px;
      cursor: pointer;
    }

    button:hover {
      background-color: #0056b3;
    }

    /* Calendar Section */
    #calendar {
      /* Placeholder for calendar styles */
    }

    /* Reserved Dates List */
    #reserved-dates-list {
      list-style-type: none;
      padding: 0;
      color: #000000;
    }

    #reserved-dates-list li {
      margin: 5px 0;
      padding: 5px;
      background-color: #ffd500;
      border: 1px solid #000000;
      border-radius: 4px;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    #reserved-dates-list button {
      background-color: #d9534f;
      color: #000000;
      border: none;
      padding: 5px 10px;
      border-radius: 3px;
      cursor: pointer;
    }

    #reserved-dates-list button:hover {
      background-color: #c9302c;
    }

    /* Modal Styling */
    .modal {
      display: none;
      position: fixed;
      z-index: 1;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.8);
    }

    .modal-content {
      margin: auto;
      display: block;
      width: 80%;
      max-width: 700px;
    }

    #close-modal {
      position: absolute;
      top: 15px;
      right: 35px;
      color: #ff0000;
      font-size: 40px;
      font-weight: bold;
      cursor: pointer;
    }

    #close-modal:hover,
    #close-modal:focus {
      color: #ff0000;
    }

    /* Responsive Styles */
    @media (max-width: 768px) {

      table,
      th,
      td {
        font-size: 14px;
      }

      button {
        padding: 8px;
        font-size: 14px;
      }

      .modal-content {
        width: 90%;
      }

      #close-modal {
        font-size: 30px;
        right: 20px;
      }
    }

    @media (max-width: 480px) {
      .dashboard {
        padding: 10px;
      }

      table,
      th,
      td {
        font-size: 12px;
      }

      button {
        padding: 6px;
        font-size: 12px;
      }

      .modal-content {
        width: 95%;
      }

      #close-modal {
        font-size: 25px;
        right: 15px;
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
  </style>
  <script defer src="../JS/appoinment.js"></script>
</head>

<body>

  <div id="paymentSlip"
    style="display:none;  width: 700px; height: 600px; z-index: 55; position: absolute;  margin-left: 400px;margin-top: 10vh; background-color: aliceblue; border-radius: 20px;">
    <div style="width: 100%; height: 85%;  display: flex; align-items: center; justify-content: center;">
      <img id="userPhoto" src="" alt="User Payment Slip"
        style="width: 95%; height: 95%;border: 1px solid black; border-radius: 20px;">
    </div>
    <div style="width:100%;height:5%;display:flex;align-items: center; justify-content: center;">
      <h4 id="user_Id">User Id:</h4>
      <h4>&nbsp | &nbsp</h4>
      <h4 id="plan_price">Price</h4>
    </div>  
    <div style="width: 100%; height: 10%; display: flex; align-items: center;  justify-content: center;">
      <button style="margin: 10px; background-color: red;width: 100px; color: black; font-weight: bold; height: 35px;"
        onclick="deletePhoto()">Delete</button>
      <button
        style="margin: 10px; background-color: rgb(21, 255, 0);width: 100px; color: black; font-weight: bold; height: 35px;"
        onclick="Verified()">Verified</button>
      <button style="margin: 10px; width: 100px; color: black; font-weight: bold; height: 35px;"
        onclick="Casel()">Cansel</button>
    </div>
  </div>

  <div class="dashboard" id="body">

    <header>
      <h1>Verifications Membership</h1>
    </header>
    <button id="back-button" onclick="window.location.href='DashBoard.php'">Back</button>

    <main>
      <div class="search-bar">
        <input type="text" placeholder="Search">
        <button>Search</button>
        <button>Cancel</button>
      </div>

      <section class="appointments" id="div_1">
        <h2>Pendinng-user</h2>
        <div style="width: auto; height:300px; overflow-y: scroll;">
          <table>
            <thead>
              <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>NIC</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Age</th>
                <th>Membership Plan</th>
                <th>Verifications</th>
              </tr>
            </thead>

            <tbody>
            <?php
    
               $sql = "SELECT user_id, email, user_name, NIC, gender, p_number, age, membership_plan 
                      FROM users 
                      WHERE membership_status = 0 AND payment_slip != 'null'";
              $result = $conn->query($sql);


               if ($result->num_rows > 0) {
                 while($row = $result->fetch_assoc()) {
                  echo "<tr>";
                  echo "<td>" . $row['user_id'] . "</td>";
                  echo "<td>" . $row['user_name'] . "</td>";
                  echo "<td>" . $row['email'] . "</td>";
                  echo "<td>" . $row['NIC'] . "</td>";
                  echo "<td>" . $row['gender'] . "</td>";
                  echo "<td>" . $row['p_number'] . "</td>";
                  echo "<td>" . $row['age'] . "</td>";
                  echo "<td>" . $row['membership_plan'] . "</td>";
                  echo '<td><button onclick="ViewPaymentSlip(\'' . $row['user_id'] . '\')">View</button></td>';
                  echo "</tr>";
                 }
               } else {
              echo "<tr><td colspan='9'>No active members found</td></tr>";
              }


               ?>
              
              
              
              
              
              <!-- Add more rows as needed -->
            </tbody>

          </table>
        </div>
      </section>

      <div id="paymentSlipAfterV"
        style="display:none;  width: 500px; height: 500px; z-index: 55; position: absolute;  margin-left: 350px;margin-top: 55vh; background-color: aliceblue; border-radius: 20px;">
        <div style="width: 100%; height: 85%;  display: flex; align-items: center; justify-content: center;">
          <img id="userPhotoAV" src="" alt="User Payment Slip"
            style="width: 95%; height: 95%;border: 1px solid black; border-radius: 20px;">
        </div>
        <div style="width:100%;height:5%;display:flex;align-items: center; justify-content: center;">
           <h4 id="useridV" style="color: black;">User Id:</h4>
           
        </div>
        <div style="width: 100%; height: 10%; display: flex; align-items: center;  justify-content: center;">

        <button onclick="UnVerification()" style="background-color: yellow; color: black; height: 35px;  font-weight: bold;">Unverified</button>
        <button style="margin: 10px; width: 100px; color: black; font-weight: bold; height: 35px;"
            onclick="CaselAfterV()">Cansel</button>
          
        </div>
      </div>

      <!-- Payment Slips Section -->
      <section class="payment-slips" id="div_2">
        <h2>Verified Users</h2>
        <div style="width: auto; height:300px; overflow-y: scroll;">
          <table>
            <thead>
              <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>NIC</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Age</th>
                <th>Membership Plan</th>
                <th>Paymnet Slip</th>
               
              </tr>
            </thead>
            <tbody>
            <?php
    
              $sql = "SELECT user_id, email, user_name, NIC, gender, p_number, age, membership_plan 
                       FROM users 
                       WHERE membership_status = 1 AND payment_slip != 'null'";
              $result = $conn->query($sql);


    if ($result->num_rows > 0) {
      while($row = $result->fetch_assoc()) {
       echo "<tr>";
       echo "<td>" . $row['user_id'] . "</td>";
       echo "<td>" . $row['user_name'] . "</td>";
       echo "<td>" . $row['email'] . "</td>";
       echo "<td>" . $row['NIC'] . "</td>";
       echo "<td>" . $row['gender'] . "</td>";
       echo "<td>" . $row['p_number'] . "</td>";
       echo "<td>" . $row['age'] . "</td>";
       echo "<td>" . $row['membership_plan'] . "</td>";
       echo '<td><button onclick="ViewPaymnetSlipAfterV(\'' . $row['user_id'] . '\')">View</button></td>';
       echo "</tr>";
      }
    } else {
   echo "<tr><td colspan='8'>No active members found</td></tr>";
   }


    ?>
              
            </tbody>
          </table>
        </div>
      </section>

      <section class="payment-slips" id="div_3">
        <h2>Unverified Users</h2>
        <div style="width: auto; height:300px; overflow-y: scroll;">
          <table>
            <thead>
              <tr>
                <th>User Id</th>
                <th>Name</th>
                <th>Email</th>
                <th>NIC</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Age</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
            <?php
    
             $sql = "SELECT user_id, email, user_name, NIC, gender, p_number, age, membership_plan 
                     FROM users 
                     WHERE membership_status = 0 AND payment_slip = 'null'";
            $result = $conn->query($sql);


           if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['user_name'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['NIC'] . "</td>";
                echo "<td>" . $row['gender'] . "</td>";
                echo "<td>" . $row['p_number'] . "</td>";
                echo "<td>" . $row['age'] . "</td>";
               
                echo '<td><button onclick="DeleteUser(\'' . $row['user_id'] . '\')" style="background-color: red;">Delete</button></td>';
                echo "</tr>";
              }
           } else {
           echo "<tr><td colspan='8'>No active members found</td></tr>";
          }


        ?>
            </tbody>
            
          </table>
        </div>
      </section>

    </main>
  </div>

</body>

</html>