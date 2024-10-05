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
    <h2 class="text-center">Membership Management</h2>
    <hr>
    <div class="row text-center">

    <?php 
       $sqlPlan = "SELECT * FROM membership";
         $resultPlan = $conn->query($sqlPlan);
            if ($resultPlan->num_rows > 0) {
                while($row = $resultPlan->fetch_assoc()) {
                    
                           echo'
                             <!-- Card 1 -->
                               <div class="col-md-4 mb-4">
                                  <div class="card text-white bg-dark">
                                    <div class="card-body">
                                      <h5 class="card-title">'.$row["name"].'</h5>
                                       <h3 class="text-warning">'.$row["price"].'</h3>
                                        <ul class="list-unstyled">
                                          <li>'.$row["benefits_1"].'</li>
                                          <li>'.$row["benefits_2"].'</li>
                                          <li>'.$row["benefits_3"].'</li>
                                          <li>'.$row["benefits_4"].'</li>
                                          <li>'.$row["benefits_5"].'</li>
                                          <li>'.$row["p_id"].'</li>
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
                <option value="plan1" selected>Select one</option>
                <option value="P001">P001</option>
                <option value="P002">P002</option>
                <option value="P003">P003</option>
            </select>
        </div>
    </div>
</div>

<!-- Input Field Section -->
<div class="container mt-5">
   
        <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
        <form method="POST" action="addInstructor2.php">
            <div class="mb-3">
                <label for="P_D" class="form-label">Plan Duration </label>
                <input type="text" class="form-control" id="P_D" name="P_D" value="" required>
            </div>
            <div class="mb-3">
                <label for="P_P" class="form-label">Plan Price</label>
                <input type="text" class="form-control" id="P_P" name="P_P" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_01" class="form-label">Benefit 01 </label>
                <input type="text" class="form-control" id="B_01" name="B_01" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_02" class="form-label">Benefit 02</label>
                <input type="text" class="form-control" id="B_02" name="B_02" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_03" class="form-label">Benefit 03</label>
                <input type="text" class="form-control" id="B_03" name="B_03" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_04" class="form-label">Benefit 04</label>
                <input type="text" class="form-control" id="B_04" name="B_04" value="" required>
            </div>
            <div class="mb-3">
                <label for="B_05" class="form-label">Benefit 05</label>
                <input type="text" class="form-control" id="B_05" name="B_05" value="" required>
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

    if (plan !== "") {
        // AJAX request to get plan details
        fetch('getPlanDetails.php', {
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
            document.getElementById('P_D').value = data.planDuration;
            document.getElementById('P_P').value = data.planPrice;
            document.getElementById('B_01').value = data.benefit1;
            document.getElementById('B_02').value = data.benefit2;
            document.getElementById('B_03').value = data.benefit3;
            document.getElementById('B_04').value = data.benefit4;
            document.getElementById('B_05').value = data.benefit5;
        })
        .catch(error => console.error('Error:', error));
    }
});

</script>
</body>
</html>
