<?php
include 'phpcon.php';


// if ($_SERVER["REQUEST_METHOD"] == "POST" && $_POST['text'] == 'search') {
//     $search = $_POST['search'];

//     $sqlSearch = "SELECT * FROM zoom_clz WHERE Id LIKE '%$search%' ";
//     $result = $conn->query($sqlSearch);
    
//     if ($result->num_rows > 0) {
//         // Fetch data as an associative array
//         $row = $result->fetch_assoc();
//         echo json_encode([
//             'Clz_Id' => $row['Id'],
//             'Topic' => $row['Topic'],
//             'Instructor_name' => $row['Instructor_name'],
//             'time' => $row['Time'],
//             'date' => $row['date'],
//             'link' => $row['Link']
//         ]);
//     } else {
//         echo json_encode(['error' => 'No data found']);
//     }
// }
    
   

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
            <input class="form-control me-2" type="search"id="search_text" placeholder="Search Memberships" aria-label="Search">
            <button class="btn btn-outline-success"id="search" type="submit">Search</button>
        </form>
    </div>
</div>
    

<!-- Input Field Section -->
<div class="container mt-5">
   
        <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
        <form method="POST" action="addInstructor2.php">
            <div class="mb-3" style="display:none">
                <label for="C_I" class="form-label">Class ID </label>
                <input type="text" class="form-control" id="C_I" name="C_I" value="" required>
            </div>
            <div class="mb-3">
                <label for="T_P" class="form-label">Topic</label>
                <input type="text" class="form-control" id="T_P" name="T_P" value="" required>
            </div>
            <div class="mb-3">
                <label for="I_N" class="form-label">Instructor Name</label>
                <input type="text" class="form-control" id="I_N" name="I_N" value="" required>
            </div>
            <div class="mb-3">
                <label for="S_T" class="form-label"> Start Time </label>
                <input type="text" class="form-control" id="S_T" name="S_T" value="" required>
            </div>
            
            <div class="mb-3">
                <label for="D_A" class="form-label">Date</label>
                <input type="date" class="form-control" id="D_A" name="D_A" value="" required>
            </div>
            <div class="mb-3">
                <label for="L_K" class="form-label">Link</label>
                <input type="text" class="form-control" id="L_K" name="L_K" value="" required>
            </div>
           
            
            <div class="text-center">
                <button type="submit"  id="sumbit" class="btn btn-primary  mb-3" style="display:show">Submit</button>
                <button type="reset" class="btn btn-secondary  mb-3">Reset</button>
                <button type="delete" class="btn btn-danger mb-3">Delete</button>
                <button type="delete" id="updated" class="btn btn-warning mb-3" style="display:none">Update</button>
            </div>
        </form>
      </div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('search').addEventListener('click', function(e) {
        e.preventDefault();
        let searchText = document.getElementById('search_text').value;
        if (searchText.trim() === '') {
            alert('Please enter a search keyword');
            return;
        }
        
        fetch('getclzdetail.php', {
            method: 'POST',
            body: JSON.stringify({ search: searchText, text: 'search' }),
            headers: {
            'Content-type': 'application/json; charset=UTF-8'
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);
            if (data.error) {
            alert(data.error);
            } else {

                document.getElementById('C_I').value = data.Clz_Id;
                document.getElementById('T_P').value = data.Topic;
                document.getElementById('I_N').value = data.Instructor_name;
                document.getElementById('S_T').value = data.time;
               
                let formattedDate = data.date.replace(/\//g, '-');
                document.getElementById('D_A').value = formattedDate;

                document.getElementById('L_K').value = data.link;

                document.getElementById('sumbit').style.display = 'none';
                document.getElementById('updated').style.display = '';

            }
        })
        .catch(error => console.error('Error:', error));

    });
</script>
</body>
</html>
