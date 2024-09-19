<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); 
header("Pragma: no-cache");
header("Expires: 0"); 

session_start();
include 'phpcon.php';
$date = date('Y-m-d H:i:s');
$date_now = date('Y-m-d');

$pendign_user = 0;

if(isset($_SESSION['admin_Id'])) {
  unset($_SESSION['Password']);
  $stmt = $conn->prepare("SELECT * FROM admin WHERE admin_Id = ?");
  $stmt->bind_param("s", $_SESSION['admin_Id']);
  $stmt->execute();
  $result = $stmt->get_result();
  $admin = $result->fetch_assoc();

  $adminName = $admin['user_name'];
  $adminID = $admin['admin_Id'];
} else {
  header('Location: index.php');
}

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT COUNT(*) AS total_users FROM users";  // Replace your_table_name with the actual table name
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $totalUser = $row['total_users'];
} else {
  $totalUser = "N/A";
}

$sql_pending_user = "SELECT COUNT(*) AS total_users_pending FROM users WHERE membership_status = 0 AND payment_slip != 'null'";  // Replace your_table_name with the actual table name
$result_pending_user = $conn->query($sql_pending_user);

if ($result_pending_user->num_rows > 0) {
    $row = $result_pending_user->fetch_assoc();
  $pendign_user = $row['total_users_pending'];
} else {
  $pendign_user = "N/A";
}

$sql_m_user = "SELECT COUNT(*) AS total_users_pending FROM users WHERE membership_status = 1 ";  
$result_m_user = $conn->query($sql_m_user);

if ($result_m_user->num_rows > 0) {
  $row = $result_m_user->fetch_assoc();
  $m_user = $row['total_users_pending'];
} else {
  $m_user = "N/A";
}

$sql_I_user = "SELECT COUNT(*) AS total_users_pending FROM users WHERE instructor_status = 1 ";  
$result_I_user = $conn->query($sql_I_user);

if ($result_I_user->num_rows > 0) {
  $row = $result_I_user->fetch_assoc();
  $I_user = $row['total_users_pending'];
} else {
  $I_user = "N/A";
}

$sql_revenue = "SELECT SUM(m.cost) AS total_revenue
                FROM membership_user AS m
                JOIN users AS u ON m.user_id = u.user_id
                WHERE m.end_date >= CURDATE() 
                AND u.membership_status = 1;
                ";  
$result_revenue = $conn->query($sql_revenue);
if ($result_revenue->num_rows > 0) {
  $row = $result_revenue->fetch_assoc();
  $revenue = $row['total_revenue'];
} else {
  $revenue = "N/A";
}

if(isset($_POST['logout'])) {
  session_destroy();
  echo json_encode(array('success' => true));
  exit();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Dashboard</title>
  
  <style>
    /* General Styles */
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      background-image: url(../IMG/bg5.png);
      background-size: cover;
      background-repeat: no-repeat;

    }
    section {
            margin-top: 200px;
            padding: 50px;
            background-color: #f1f1f1;
            border: 1px solid #ccc;
        }
    /* Sidebar */
    .sidebar {
      width: 250px;
      background-color: #333;
      color: rgb(255, 255, 0);
      height: 100vh;
      padding-top: 20px;
      position: fixed;
      transition: width 0.3s ease;
    }

    /* Sidebar Logo */
    .sidebar .logo {
      font-size: 24px;
      text-align: center;
      margin-bottom: 30px;
    }

    /* Responsive Adjustments */
    @media (max-width: 1024px) {
      .sidebar .logo {
        font-size: 20px;
        margin-bottom: 20px;
      }
    }

    @media (max-width: 768px) {
      .sidebar .logo {
        font-size: 18px;
        margin-bottom: 15px;
      }
    }

    @media (max-width: 480px) {
      .sidebar .logo {
        font-size: 16px;
        margin-bottom: 10px;
      }
    }

    .sidebar .nav-links {
      list-style: none;
      padding: 0;
      margin: 0;
    }

    .sidebar .nav-links li {
      padding: 15px;
      transition: background-color 0.3s ease;
      /* Smooth transition for the background fill */
    }

    .sidebar .nav-links li a {
      color: #f8d700;
      text-decoration: none;
      display: block;
      width: 100%;
      height: 100%;
    }

    .sidebar .nav-links li:hover {
      background-color: #f8d700;
      /* Full fill on hover with color yellow in admin panel  */
    }

    .sidebar .nav-links li:hover a {
      color: #000000;
      /* Change text color with hover  */
    }

    .sidebar.collapsed {
      width: 60px;
    }

    .sidebar.collapsed .nav-links li {
      text-align: center;
    }

    .sidebar.collapsed .nav-links li a {
      display: block;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    /* Main Content */
    .main-content {
      margin-left: 250px;
      padding: 20px;
      width: calc(100% - 250px);
      transition: margin-left 0.3s ease, width 0.3s ease;
    }

    .main-content.collapsed {
      margin-left: 60px;
      width: calc(100% - 60px);
    }

    .navbar {
      display: flex;
      position: fixed;
      width: calc(95.5% - 250px);
      justify-content: space-between;
      align-items: center;
      background-color: #c0bd62;
      padding: 10px; 
      margin-bottom: 10px;
    }

    .search-bar input {
      padding: 10px;
      width: 100%;
      max-width: 300px;
    }

    .profile img {
      width: 40px;
      border-radius: 50%;
    }

    /* Dashboard Cards */
    .dashboard-cards {
      display: flex;
      gap: 20px;
      flex-wrap: wrap;
    }

    .card {
      display: 1;
      
      padding: 20px;
      background-color: #cec10d;
      border-radius: 10px;
      box-shadow: 0px 4px 8px #00000000;
      min-width: 180px;
    }

    /* Data Table */
    .data-table table {
      width: 100%;
      border-collapse: collapse;
      overflow-x: auto;
      color: azure;
    }

    .data-table th,
    .data-table td {
      padding: 12px;
      border: 1px solid #fff200f6;
      text-align: left;
    }

    h3 {
      color: azure;
      
    }
    .Logout-button{
      width: 100%;
      height: 100%;
      background-color: transparent;
      border: none;
      text-align: left;
      color: red;
      font-size: 18px;
      cursor: pointer;
    }
    /* Responsive Styles */
    @media (max-width: 1024px) {
      .card {
        flex-basis: calc(50% - 20px);
      }
    }

    @media (max-width: 768px) {

      /* Sidebar collapses */
      .sidebar {
        width: 60px;
      }

      .sidebar .nav-links li {
        text-align: center;
      }

      .main-content {
        margin-left: 60px;
        width: calc(100% - 60px);
      }

      /* Cards stack on top of each other */
      .dashboard-cards {
        display: block;
      }

      .card {
        width: 100%;
        margin-bottom: 20px;
      }

      /* Search bar and profile image responsive */
      .search-bar input {
        width: 100%;
      }
    }

    /* Small Mobile */
    @media (max-width: 480px) {
      .card {
        flex-basis: 100%;
        padding: 10px;
      }

      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .data-table table {
        display: block;
        overflow-x: auto;
      }
    }
  </style>
  <script>
        
        function updateTime() {
            
            let currentTime = new Date();
            
            let formattedTime = currentTime.getFullYear() + '-' +
                ('0' + (currentTime.getMonth() + 1)).slice(-2) + '-' +
                ('0' + currentTime.getDate()).slice(-2) + ' ' +
                ('0' + currentTime.getHours()).slice(-2) + ':' +
                ('0' + currentTime.getMinutes()).slice(-2) + ':' +
                ('0' + currentTime.getSeconds()).slice(-2);
            
            document.getElementById('liveTime').innerHTML = formattedTime;
        }

        
        window.onload = function() {
            setInterval(updateTime, 1000); 
        };
        
        


    </script>
</head>

<body>
  <!-- Sidebar Navigation -->
  <div class="sidebar">
    <div class="logo">FITNESS ZONE</div>
    <ul class="nav-links">

      <li><a href="instructor.html">Instructor Login</a></li>
      <li><a href="CheckUser.php">Check User</a></li>
      <li><a href="Passwordchek.php">Verifications Membership <span style="color:red; font-size:20px; font-weight:bold"> &nbsp<?php echo $pendign_user ?></span></a></li>
      <li><a href="news.html">Membership Manage</a></li>
      <li><a href="appoinment.html">Online Class Manage</a></li>
      <li><a href="appoinment.html">Instruct Display Manage</a></li>
      <li><a href="#">Report Generator</a></li>
      <li><input id="Logout-btn" class="Logout-button" type="button" value="Log out"></li>

    </ul>
  </div>

  <!-- Main Content -->
  <div class="main-content">
    <!-- Top Navbar -->
    <div class="navbar">
      <div class="search-bar">
        <input type="button" placeholder="Add Instructor" value="Add Instructor">
     </div>
     <select id="scrollSelect" style="width: 400px; height: 40px; border-radius: 20px;font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 16px; text-align: center; background-color: rgba(240, 248, 255, 0.3); border-color: #f8d700;">
        <option value="Home">Easy to Navigation</option>
        <option value="Pendinng-user-List">Pendinng user List</option>
        <option value="Instructor-List">Instructor List</option>
        <option value="Membership-have-User-List">Membership have User List</option>
        <option value="Instructor-have-User-List">Instructor have User List</option>
        
      </select>
      <div class="profile">
        <span style="font-weight: bold; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 18px; "><?php echo $adminName; ?></span>
        <span style="font-weight: bold; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 18px; ">(<?php echo $adminID; ?>)</span>
        <span id="liveTime" style="font-weight: bold; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 18px; "><?php echo $date; ?></span>
      </div>
    </div>
    <div id="Home" style="width: 100%; height: 100px;"> 
    </div>
    <!-- Dashboard Cards -->
    <div class="dashboard-cards">
      <div class="card">
        <h3 style=" text-align:center">Total Users</h3>
        <p style="font-weight: bold; font-size:20px; text-align:center"><?php echo $totalUser ?></p>
        
      </div>
      <div class="card">
        <h3 style=" text-align:center">Pending User</h3>
        <p style="font-weight: bold; font-size:20px; text-align:center;color:red"><?php echo $pendign_user ?></p>
        
      </div>
      <div class="card">
        <h3 style=" text-align:center">Membership have User</h3>
        <p style="font-weight: bold; font-size:20px; text-align:center;"><?php echo $m_user?></p>
        
      </div>
      <div class="card">
        <h3 style=" text-align:center">Instructor have User</h3>
        <p style="font-weight: bold; font-size:20px; text-align:center;"><?php echo $I_user ?></p>
        
      </div>
      <div class="card">
        <h3 style=" text-align:center">Revenue</h3>
        <p style="font-weight: bold; font-size:20px; text-align:center; color:green">RS :<?php echo $revenue?>.00</p>
      </div>
      <!-- Add more cards -->
    </div>

    <!-- Table for Data -->
    <div class="data-table">
      <h3 id="Pendinng-user-List">Pending User List</h3>
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
                  echo "</tr>";
             }
           } else {
             echo "<tr><td colspan='8'>No active members found</td></tr>";
        }

   
    ?>
        </tbody>
      </table>
      <hr>
      <h3 id ="Instructor-List">Instructor List</h3>
      <table border="1">
        <thead>
          <tr>
            <th>NIC</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Phone number</th>
            <th>Instructor ID</th>
          </tr>
        </thead>
        <tbody>
        <?php
    
    
             $sql = "SELECT NIC,email, user_name, Password, p_number, Instrutor_ID FROM instrutor";  
             $result = $conn->query($sql);

             if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . $row['NIC'] . "</td>";
                      echo "<td>" . $row['user_name'] . "</td>";
                      echo "<td>" . $row['email'] . "</td>";
                      echo "<td>" . $row['Password'] . "</td>";
                      echo "<td>" . $row['p_number'] . "</td>";
                      echo "<td>" . $row['Instrutor_ID'] . "</td>";
                      echo "</tr>";
                }
             } else {
                 echo "<tr><td colspan='6'>No instructors found</td></tr>";
            }

   
           
        ?>
        </tbody>
      </table>
      <hr>
      <h3 id ="Membership-have-User-List">Membership have User List</h3>
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
           
          </tr>
        </thead>
        <tbody>
        <?php
    
          $sql = "SELECT user_id, email, user_name, NIC, gender, p_number, age, membership_plan 
                  FROM users 
                 WHERE membership_status = 1  ";
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
                 echo "</tr>";
              }
            } else {
               echo "<tr><td colspan='7'>No active members found</td></tr>";
           }

         ?>
        </tbody>
      </table>
      <hr>
      <h3 id = "Instructor-have-User-List">Instructor have User List</h3>
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
            <th>Instructor</th>
          </tr>
        </thead>
        <tbody>
        <?php
    
            $sql = "SELECT user_id, email, user_name, NIC, gender, p_number, age, instructor 
                     FROM users 
                     WHERE instructor_status = 1  ";
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
                   echo "<td>" . $row['instructor'] . "</td>";
                   echo "</tr>";
              }
           } else {
            echo "<tr><td colspan='8'>No active members found</td></tr>";
         }
  
     ?>
        </tbody>
      </table>
    </div>

  </div>

  <script>
    document.getElementById('scrollSelect').addEventListener('change', function() {
        var selectedValue = this.value;

        // Only scroll if the value is not the default "#"
        if (selectedValue !== "#") {
            // Find the element by the selected value (ID) and scroll to it
            var targetDiv = document.getElementById(selectedValue);
            if (targetDiv) {
                targetDiv.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
    });
    document.getElementById('Logout-btn').addEventListener('click', function() {
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
          });
  </script>
</body>

</html>