<?php
include 'phpcon.php';
session_start();
if(!isset($_SESSION['admin_Id'])) {
   header('Location: index.php');
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .mt-custom {
            margin-top: 20px;
        }
        body {
            overflow-x: hidden;
        }
        
        body {
            background-color: #f8f9fa;
        }
        .form-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
    
    </style>
</head>
<body>
<div class="container mt-custom">
    <h2 class="text-center">OnlineClz Management</h2>
    <hr>
    <div class="row flex-nowrap overflow-auto text-center">
      <?php
        $sqlPlan = "SELECT * FROM zoom_clz";
        $resultPlan = $conn->query($sqlPlan);
        if ($resultPlan->num_rows > 0) {
            while($row = $resultPlan->fetch_assoc()) {
                echo'
                      <!-- Card 1 -->
                      <div class="col-md-4 mb-4">
                        <div class="card text-white bg-dark">
                           <div class="card-body">
                             <h5 class="card-title">'.$row["Id"].'</h5>
                             <h3 class="text-warning">'.$row["Topic"].'</h3>
                             <ul class="list-unstyled">
                              <li>'.$row["Instructor_name"].'</li>
                              <li>'.$row["Time"].'</li>
                              <li>'.$row["date"].'</li>
                              <li>'.$row["Link"].'</li>
                            </ul>
                          </div>
                       </div>
                    </div>
        ';
    }
} else {
    echo "0 results";
}
?>


           
    </div>
    <hr>
</div>
<!-- Search Bar -->
<div class="row mb-4 justify-content-center mt-4">
    <div class="col-md-6">
        <form class="d-flex">
            <input class="form-control me-2" type="search" placeholder="Search Memberships" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>
</div>
    

<!-- Input Field Section -->
<div class="container mt-5">
   
        <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
        <form method="POST" action="addInstructor2.php">
            <div class="mb-3">
                <label for="P_D" class="form-label">Plan ID </label>
                <input type="text" class="form-control" id="P_D" name="P_D" value="" required>
            </div>
            <div class="mb-3">
                <label for="P_P" class="form-label">Topic</label>
                <input type="text" class="form-control" id="P_P" name="P_P" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_01" class="form-label"> Start Time </label>
                <input type="time" class="form-control" id="B_01" name="B_01" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_01" class="form-label"> End Time </label>
                <input type="time" class="form-control" id="B_01" name="B_01" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_02" class="form-label">Date</label>
                <input type="date" class="form-control" id="B_02" name="B_02" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_03" class="form-label">Link</label>
                <input type="text" class="form-control" id="B_03" name="B_03" value="" required>
            </div>
           
            
            <div class="text-center">
                <button type="submit" class="btn btn-primary  mb-3">Submit</button>
                <button type="reset" class="btn btn-secondary  mb-3">Reset</button>
                <button type="button" class="btn btn-danger mb-3">Delete</button>
            </div>
        </form>
      </div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
