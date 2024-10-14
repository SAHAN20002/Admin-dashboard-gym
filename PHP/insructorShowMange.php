<?php 
include 'phpcon.php';
session_start();
if(!isset($_SESSION['admin_Id'])) {
   header('Location: index.php');
}
$button = "none";
$gatherSpread = "none";
$transition = "none";
$instructorId = ""; 
$insructorStatus = "SELECT * FROM instrutor WHERE Chnage_status = true";
$result = $conn->query($insructorStatus);
if ($result->num_rows > 0) {
    $button = "show";
     while($row = $result->fetch_assoc()) {
      $instructorId = $row['Instrutor_ID'];
      $addanimation = "SELECT * FROM instrutor WHERE Chnage_status = true AND Instrutor_ID = '$instructorId'";
      $result_2 = $conn->query($addanimation);

      if ($result_2->num_rows > 0) {
    
        $gatherSpread = "gatherSpread 2s ease-in-out infinite";
        $transition = "transform 0.3s ease-in-out";

      } else {
        $gatherSpread = "none";
        $transition = "none";
      }
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $I_D = $_POST['I_D'];
    $I_N = $_POST['I_N'];
    $I_P = $_POST['I_P'];
    $D_01 = $_POST['D_01'];
    $photo = isset($_FILES['photo']['name']) ? $_FILES['photo']['name'] : '';
    
    // Handle file upload
    if (!empty($photo)) {
        $target_dir = "../IMG/";
        $target_file = $target_dir . basename($photo);
        move_uploaded_file($_FILES['photo']['tmp_name'], $target_file);
    } else {
        // If no new photo is uploaded, keep the existing photo
        $photoQuery = "SELECT In_photo FROM instructor_show WHERE Instructor_Id  = '$I_D'";
        $photoResult = $conn->query($photoQuery);
        if ($photoResult->num_rows > 0) {
            $photoRow = $photoResult->fetch_assoc();
            $photo = $photoRow['In_photo'];
        }
    }

    $sql = "UPDATE instructor_show SET Name='$I_N', price='$I_P', description='$D_01', In_photo='$photo' WHERE Instructor_Id='$I_D'";
    if ($conn->query($sql) === TRUE) {
        echo '<script>alert("Record updated successfully")</script>';
        echo '<script>window.history.replaceState({}, document.title, "insructorShowMange.php");</script>';
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
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
        @keyframes gatherSpread {
           0%, 100% {
            transform: scale(1); /* Normal size at the start and end */
            
           }
           50% {
           transform: scale(1.05); /* Slightly larger size (spread) */
           }
   }

   .card {
      animation:<?php echo $gatherSpread;?>; /* 2 seconds per cycle, infinite loop */
      transition:<?php echo $transition;?>;
   }
    
    </style>
</head>
<body>
<div class="container mt-custom">
    <h2 class="text-center">Instructor Management</h2>
    <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
    <button class="btn btn-warning mb-3" style="display:<?php echo $button; ?>;" id="ChnageSataus">mark as done</button>
    <hr>
    <div class="row text-center">

    <?php 
       $sqlPlan = "SELECT * FROM instructor_show";
         $resultPlan = $conn->query($sqlPlan);
            if ($resultPlan->num_rows > 0) {
                while($row = $resultPlan->fetch_assoc()) {

                   
                           echo'
                             <!-- Card 1 -->
                               <div class="col-md-4 mb-4">
                                  <div class="card text-white bg-dark">
                                  <img src="../IMG/team-2.jpg" class="card-img-top" alt="Instructor Image">
                                    <div class="card-body">
                                      <h5 class="card-title">'.$row["Instructor_Id"].'</h5>
                                       <h3 class="text-warning">'.$row["Name"].'</h3>
                                        <ul class="list-unstyled">
                                          <li>'.$row["price"].'</li>
                                          <li>'.$row["description"].'</li>
                                         
                                        </ul>
                                     </div>
                                  </div>
                               </div>';
                            
                        }
                    }
       ?> 

        <!-- Card 3 -->
       
        <hr>
    </div>

    <!-- Dropdown Section -->
    <div class="row">
        <div class="col text-center">
            <label for="dropdown" class="form-label">Select a Plan:</label>
            <select class="form-select w-50 mx-auto" id="dropdown">
                <option value="plan" selected>Select one</option>
                <option value="IN001">IN001</option>
                <option value="IN002">IN002</option>
                <option value="IN003">IN003</option>
            </select>
        </div>
    </div>
</div>

<!-- Input Field Section -->
<div class="container mt-5">
   
        <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
        <form method="POST" action="insructorShowMange.php">
        <div class="mb-3">
                <label for="I_D" class="form-label">Instructor ID </label>
                <input type="text" class="form-control " id="I_D" name="I_D" value="" required readonly>
            </div>
            <div class="mb-3">
                <label for="I_N" class="form-label">Name </label>
                <input type="text" class="form-control " id="I_N" name="I_N" value="" required>
            </div>
            <div class="mb-3">
                <label for="I_P" class="form-label">Price</label>
                <input type="text" class="form-control" id="I_P" name="I_P" value="" required>
            </div>
            <div class="mb-3">
                <label for="D_01" class="form-label">Description </label>
                <input type="text" class="form-control" id="D_01" name="D_01" value="" required>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg mb-3">Submit</button>
                <button type="reset" class="btn btn-secondary btn-lg mb-3">Reset</button>
            </div>
        </form>
      </div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('dropdown').addEventListener('change', function() {
    let plan = this.value;
    

    if (plan !== "plan") {
        // AJAX request to get plan details
        fetch('getInstructordetails.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `plan=${plan}`,
        })
        .then(response => response.json())
        .then(data => {
            // Populate form fields with the fetched data
            console.log(data);
            document.getElementById('I_D').value = data.planId;
            document.getElementById('I_N').value = data.planDuration;
            document.getElementById('I_P').value = data.planPrice;
            document.getElementById('D_01').value = data.benefit1;
            
        })
        .catch(error => console.error('Error:', error));
    }

});
document.getElementById('ChnageSataus').addEventListener('click', function() {
        if (!confirm('Are you sure you want to mark as done?')) {
            return;
        }
        fetch('getInstructordetails.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'action=changeStatus',
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Status changed successfully');
            } else {
                alert('Failed to change status');
            }
        })
        .catch(error => console.error('Error:', error));
    });
</script>
</body>
</html>
