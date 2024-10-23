<?php
include 'phpcon.php';
include 'mailsend.php';


$instructor_Id = "";
session_start();



    $instructorDetailsQuery = "SELECT Instrutor_ID, user_name, email,Password,NIC,Avilable_Status FROM instrutor";
    $result = $conn->query($instructorDetailsQuery);

    $members = []; 
    while ($row = $result->fetch_assoc()) {
        $members[] = [
            'id' => $row['Instrutor_ID'],
            'name' => $row['user_name'],
            'email' => $row['email'],
            'password' => $row['Password'],
            'nic' => $row['NIC'],
            'status' => $row['Avilable_Status']
        ];
    }


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $nic = $_POST['nic'];
    $password = $_POST['password'];

    $chekitsavilable = "SELECT * FROM instrutor WHERE NIC = '$nic'";
    $result = $conn->query($chekitsavilable);

    if ($result->num_rows > 0) {
        echo "<script>alert('NIC already exists');window.location.href = window.location.href;</script>";
        exit;
    }

    $updateQuery = "UPDATE instrutor SET NIC = '$nic', Password = '$password' WHERE Instrutor_ID = '$member_id'";
    $conn->query($updateQuery);
    if ($conn->query($updateQuery) === TRUE) {
        echo "<script>alert('Record updated successfully'); window.location.href = window.location.href;</script>";
            } else {
        echo "<script>alert('Error updating record: " . $conn->error . "');</script>";
        
    }
   
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['member_id'])) {
        $member_id = $_GET['member_id'];
        
        // Find the member in the array
        $key = array_search($member_id, array_column($members, 'id'));
        
        if ($key !== false) {
            $member = $members[$key];
            $status = $member['status'];
            if ($status == '1') {
                $status = '0';
            } else {
                $status = '1';
            }
            
            // Use prepared statements to avoid SQL injection
            $stmt = $conn->prepare("UPDATE instrutor SET Avilable_Status = ? WHERE Instrutor_ID = ?");
            $stmt->bind_param('ss', $status, $member_id);
            
            if ($stmt->execute()) {
                echo "<script>alert('Status updated successfully.'); ";
                echo "window.history.back();</script>";
            } else {
                echo "<script>alert('Error updating status: " . $conn->error . "');</script>";
            }
            
            $stmt->close();
        } else {
            echo "<script>alert('Member not found.');</script>";
        }
        
        exit;
    }
    
}



 
?>






<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa; /* Light grey background for the whole page */
        }
        .form-container {
            background-color: #ffffff; /* White background for the form */
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Soft shadow for modern look */
            padding: 20px;
            max-width: 600px;
            margin: auto;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
    
        <div class="card-container">
            <h2 class="text-center">Instructor List (Max 3 Members)</h2>
            <button class="btn btn-secondary mb-3" onclick="window.location.href='dashboard.php'">Back</button>
            <div class="row">
                <?php foreach ($members as $member): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-header">
                            <span class="badge bg-<?= $member['status'] == '1' ? 'success' : 'secondary' ?>">
                                <?= $member['status'] == '1' ? 'Active' : 'Inactive' ?>
                            </span>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title"><?=$member['name'] ?></h5>
                            <p class="card-text"><?=$member['email'] ?></p>
                            <form method="POST" action="deleteinstructor.php">
                                <input type="hidden" name="member_id" value="<?= $member['id'] ?>">
                                <div class="mb-3">
                                    <label for="NIC" class="form-label">NIC</label>
                                    <input type="text" class="form-control" id="NIC" value="<?= $member['nic'] ?>" name="nic">
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password</label>
                                    <input type="text" class="form-control" id="password" value="<?= $member['password'] ?>" name="password">
                                </div>
                                <button type="submit" class="btn btn-warning w-100">Change</button>
                                
                            </form>
                            
                            <form method="GET" action="deleteinstructor.php">
                                <div class="mb-3 mt-3">
                                    <input type="hidden" name="member_id" value="<?= $member['id'] ?>">
                                    <button type="submit" class="btn btn-<?= $member['status'] == '1' ? 'danger' : 'success' ?> w-100">
                                        <?= $member['status'] == '1' ? 'Disable' : 'Enable' ?>
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
         
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
