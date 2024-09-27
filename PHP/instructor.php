<?php
include 'phpcon.php';
session_start();

if(!isset($_SESSION['NIC'] )){
 header('Location: index.php');
}else{
  $instructorId = $_SESSION['Instrutor_ID'];
  $total_user = "0";
  $pending_user = "0";
  $verfication_user = "0";
  $total_income = "0";


}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instructor</title>
  <!-- <link rel="stylesheet" href="instructor.css">
  <link rel="stylesheet" href="user.css"> -->
  <style>
    /* General Styling */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {
      background-color: #003a70;
      background-image: url(../IMG/ins1.jpg);
      background-size: cover;

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


    .dashboard {
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
    }

    header {
      background-color: #000000;
      padding: 15px;
      border-bottom: 1px solid #ffd000;
    }

    .breadcrumb {
      display: inline-block;
      font-size: 14px;
      color: #ffffff;
    }

    .search-and-profile {
      float: right;
    }



    .profile img {
      width: 80px;
      height: 80px;
      border-radius: 0%;
      margin-left: 20px;
    }

    /* Cover Photo and Profile Section */
    .cover-photo {
      background: linear-gradient(120deg, #000000, #7e6e12);
      color: #ffe100;
      padding: 40px;
      text-align: center;
    }

    .profile-info {
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .profile-pic img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      border: 3px solid #ff0000;

    }

    .profile-details {
      margin-left: 20px;
    }

    .profile-details h2 {
      font-size: 24px;
      margin-bottom: 5px;

    }

    .profile-details p {
      font-size: 14px;
      opacity: 0.8;
      color: #ffffff;
    }

    /* Tabs Section */
    .tabs {
      display: flex;
      justify-content: space-around;
      background-color: #000000;
      padding: 10px 0;
      border-bottom: 1px solid #a9a88e;
    }

    .tab {
      background: none;
      border: none;
      padding: 10px 20px;
      cursor: pointer;
      font-size: 16px;
      color: #ffffff;
    }

    .tab.active {
      border-bottom: 2px solid #ffe100;
      color: #ffe100;
    }

    .tab span {
      background-color: #e73c3c;
      color: #ffffff;
      border-radius: 50%;
      padding: 2px 7px;
      font-size: 12px;
    }

    /* Content Section */
    .dashboard-content {
      padding: 20px;
      background-color: #554a0c;
      min-height: 300px;
    }

    /* Footer Section */
    footer {
      display: flex;
      justify-content: space-between;
      padding: 10px;
      background-color: #000000;
      border-top: 1px solid #ddd;
    }

    .share-profile {
      background-color: #ffe100;
      color: #000000;
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      cursor: pointer;
    }

    .teams {
      font-size: 14px;
      color: #ffe100;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
      .profile-info {
        flex-direction: column;
      }

      .profile-details {
        margin: 10px 0 0 0;
      }

      .tabs {
        flex-direction: column;
      }
    }


    /* styles.css */
    /* body */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }

    body {

      background-image: url(../IMG/user2.jpg);
      background-size: cover;

    }

    /* Style for the logo container */
    .logo-container {
      position: absolute;
      top: 10px;
      left: 1250px;
      z-index: 1;
    }

    /* Style for the logo image */
    #logo {
      width: 190px;
      height: auto;
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
      margin-left: -130px;
    }



    #back-button:hover {
      background-color: #ffe600;
    }


    #back-button:focus {
      outline: 2px solid #b3a700;
      outline-offset: 2px;
    }


    .admin-panel {
      max-width: 1100px;
      margin: 0 auto;
      padding: 20px;
    }

    header {
      text-align: center;
      margin-bottom: 20px;
    }

    h1 {
      font-size: 40px;
      color: #e9ba11;
    }

    main {
      background-color: #e9ba11;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 0 10px #e9ba11;
    }

    /* Profile Header */
    .user-profile .profile-header {
      display: flex;
      align-items: center;
      margin-bottom: 20px;
    }

    .profile-image img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-right: 20px;
      cursor: pointer;
    }

    .profile-info h2 {
      font-size: 22px;
      margin-bottom: 5px;
    }

    .profile-info p {
      font-size: 14px;
      color: #ffffff;
    }

    /* Profile and Bank Details */
    .profile-details,
    .bank-details {
      margin-bottom: 20px;
    }

    h3 {
      margin-bottom: 15px;
      font-size: 18px;
      border-bottom: 2px solid #348ddb;
      padding-bottom: 5px;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      margin-bottom: 10px;
    }

    .info-row label {
      font-weight: bold;
      color: #333;
    }

    .info-row input {
      padding: 8px;
      border-radius: 4px;
      border: 1px solid #000000;
      width: 60%;
      background-color: #ffffff;
    }

    input:disabled {
      background-color: #e0e0e0;
    }

    /* Profile Actions */
    .profile-actions {
      display: flex;
      justify-content: flex-end;
    }

    .profile-actions button {
      background-color: #0866a4;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 4px;
      cursor: pointer;
      margin-left: 10px;
      transition: background-color 0.3s ease;
    }

    .profile-actions button:hover {
      background-color: #980101;
    }

    button#save-profile {
      background-color: #0e9b49;
    }

    button#save-profile:hover {
      background-color: #065929;
    }

    /* Responsive Design */
    @media (max-width: 600px) {
      .user-profile .profile-header {
        flex-direction: column;
        text-align: center;
      }

      .profile-image img {
        margin: 0 0 15px 0;
      }

      .info-row {
        flex-direction: column;
        align-items: flex-start;
      }

      .profile-actions {
        flex-direction: column;
        align-items: flex-start;
      }

      .profile-actions button {
        width: 100%;
        margin: 10px 0 0;
      }
    }


    /* Ensure dashboard-content takes up full width */
    .dashboard-content {
      width: 100%;
    }

    /* Photo Gallery */
    .photo-gallery {
      display: flex;
      justify-content: space-around;
      flex-wrap: wrap;
      gap: 20px;
    }

    .photo-item {
      text-align: center;
      display: block;
      width: 100%;
      max-width: 300px;
      border: 2px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
      transition: transform 0.3s ease;
    }

    .photo-item img {
      width: 100%;
      height: auto;
      display: block;
    }

    .photo-item p {
      margin: 10px 0;
      font-size: 16px;
      color: #333;
    }

    .photo-item:hover {
      transform: scale(1.05);
      border-color: #007bff;
    }

    @media (max-width: 768px) {
      .photo-item {
        max-width: 100%;
      }
    }

    /* Dashboard Cards */
    a {
      text-decoration: none;
      color: black;
    }

    .dashboard-cards {
      display: flex;
      margin-top: 20px;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      flex: 1;
      height: 150px;
      align-items: center;
      justify-content: center;
      padding: 20px;
      background-color: #cec10d;
      border-radius: 10px;
      box-shadow: 0px 4px 8px #00000000;
      min-width: 200px;
    }

    h4 {
      font-size: 40px;
    }
  </style>
  <!-- <script defer src="JS/instructor.js"></script> -->
</head>

<body>


  <div class="dashboard">
    <header>
      <nav>


        <div class="profile">
          <img src="IMG/gym copy.png" alt="User Profile">
        </div>
  </div>
  </nav>
  </header>

  <div class="cover-photo">
    <div class="profile-info">
      <div class="profile-pic">
        <img src="IMG/1.JPEG" alt="Meryl Streep">
      </div>
      <div class="profile-details">
        <h2>Isuru Madushanka</h2>
        <p>Fitness Zone | Panadura,Sri Lanka | 076 914 5792</p>
        <input type="button" id="Logout" value="Logout"
          style="width: 150px; height: 30px; margin-top: 10px; font-size: 20px; background-color: yellow; font-weight: bold; cursor: pointer; border: none; border-radius: 5px;">
      </div>

    </div>
  </div>

  <div class="dashboard-main">
    <nav class="tabs">
      <!-- <button id="back-button" onclick="window.history.back()">Back</button> -->
      <a href="user.html" class="tab">Profile</a>
      <a href="appoinment.html" class="tab">Appoinments</a>
      <a href="class.html" class="tab">User Verified</a>

    </nav>

    <div class="dashboard-content">


      <div class="dashboard-cards">
        <div class="card">
          <h3>Total Users</h3>
          <h4><?php echo $total_user ?></h4>
        </div>
        <div class="card">
          <h3>Pending User</h3>
          <h4 style="color: red;"><?php echo $pending_user ?></h4>
        </div>
        <div class="card">
          <h3>Verified user </h3>
          <h4><?php echo $verfication_user ?></h4>
        </div>
        <div class="card">
          <h3>Revenue</h3>
          <h4 style="color: green;">$<?php echo $total_income ?></h4>
          <h4 style="color: green;">$<?php echo $instructorId ?></h4>
        </div>
        <!-- Add more cards -->
      </div>



    </div>


    <footer>

      <div class="teams">
        <span>FITNESS ZONE | INSTRUCTOR</span>
      </div>
    </footer>
  </div>
  </div>

  <script>
    document.getElementById("Logout").onclick = function () {
      if (confirm('Are you sure you want to log out?')) {
        let formData = new FormData();
        formData.append('logout', 'logout');
        fetch('DashBoard.php', {
          method: 'POST',
          body: formData
        })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              window.location.href = 'index.php';
            }
          });
      }

    };
  </script>

</body>

</html>