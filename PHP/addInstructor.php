<?php
include 'phpcon.php';
include 'mailsend.php';
include 'imageupload.php';

$instructor_Id = "";
session_start();
if(isset($_SESSION['admin_Id'])) {

    $get_instructor_Id = "SELECT * FROM instrutor";  // Corrected the table name
    $result = $conn->query($get_instructor_Id);
    
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $last_id = $row['Instrutor_ID'];  // Ensure the column name is correct
        }
        
        // Extract the numeric part and increment it
        $num = (int)substr($last_id, 2);
        $num++;
        
        // Format the new ID
        $instructor_Id = "IN" . str_pad($num, 3, "0", STR_PAD_LEFT);
    } else {
        $instructor_Id = "IN001";  // Default if no rows are found
    }

} else {
    header('Location: index.php');
}
$max_members = 3;
$instructorCountQuery = "SELECT COUNT(*) AS count FROM instrutor";
$result = $conn->query($instructorCountQuery);
$row = $result->fetch_assoc();
$current_members_count = isset($row['count']) ? $row['count'] : 0;


if ($current_members_count > 0) {
    $instructorDetailsQuery = "SELECT Instrutor_ID, user_name, email FROM instrutor";
    $result = $conn->query($instructorDetailsQuery);

    $members = []; 
    while ($row = $result->fetch_assoc()) {
        $members[] = [
            'id' => $row['Instrutor_ID'],
            'name' => $row['user_name'],
            'email' => $row['email']
        ];
    }
} else {
    $members = []; 
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nic = $_POST['nic'];
    $email = $_POST['email'];
    $user_name = $_POST['user_name'];
    $password = $_POST['password'];
    $c_password = $_POST['c_password'];
    $p_number = $_POST['p_number'];
    $description = $_POST['description'];
    $photo = $_POST['photo'];
    $age = $_POST['age'];
    

    $emailQuery = "SELECT * FROM instrutor WHERE email = '$email'";
    $emailResult = $conn->query($emailQuery);
    if ($emailResult->num_rows > 0) {
        echo "<script>alert('Email already exists');</script>";
    } else {
        $emailuserchek = "SELECT * FROM users WHERE email = '$email'";
        $emailuserchekresult = $conn->query($emailuserchek);
        if ($emailuserchekresult->num_rows > 0) {
            echo "<script>alert('Email already registered in users');</script>";
            
            
        } else {
            if ($password == $c_password) {
             $random_code = rand(1000, 9999);
             $photo = saveImage($_FILES['photo']);
             $imagelink = "http://localhost/sahan/ADMIN-MAIN/".$photo;

            $insertQuery = "INSERT INTO instrutor (Instrutor_ID, NIC, email, user_name, Password, p_number, description, photo, age,email_v_code) VALUES ('$instructor_Id', '$nic', '$email', '$user_name', '$password', '$p_number', '$description', '$imagelink', '$age','$random_code')";
                if ($conn->query($insertQuery) === TRUE) {
                    $_SESSION['Instrutor_ID'] = $instructor_Id;
                    $to = $email;
                    $subject = "Email Verification Code";
                    $message = "Your email verification code is: $random_code";
                    $headers = "From:";

                    if(mailsend($to, $subject, $message, $headers)) {
                        echo "<script>alert('Email sent to verify email.');</script>";
                        header('Location: email_v.php');
                    } else {
                        echo "<script>alert('Failed to send email.');</script>";
                    }

                   
                } else {
                    echo "Error: " . $insertQuery . "<br>" . $conn->error;
                }
            } else {
                echo "<script>alert('Password does not match');</script>";
            }
        }
        
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
    <?php if ($current_members_count < $max_members): ?>
        <h2 class="text-center">Insert Insructor</h2>
        <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
        <form method="POST" action="addInstructor.php">
            <div class="mb-3">
                <label for="I_ID" class="form-label">Instructor ID</label>
                <input type="text" class="form-control" id="I_Id" name="Instructor ID" value="<?php echo $instructor_Id?>" required disabled>
            </div>
            <div class="mb-3">
                <label for="nic" class="form-label">NIC</label>
                <input type="number" class="form-control" id="nic" name="nic" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="user_name" class="form-label">Username</label>
                <input type="text" class="form-control" id="user_name" name="user_name" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="c_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="c_password" name="c_password" required>
            </div>
            <div class="mb-3">
                <label for="p_number" class="form-label">Phone Number</label>
                <input type="number" class="form-control" id="p_number" name="p_number" required>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="photo" class="form-label">Photo</label>
                <input type="file" class="form-control" id="photo" name="photo">
            </div>
            <div class="mb-3">
                <label for="age" class="form-label">Age</label>
                <input type="number" class="form-control" id="age" name="age" required>
            </div>
            <div class="mb-3">
               
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary btn-lg mb-3">Submit</button>
                <button type="reset" class="btn btn-secondary btn-lg mb-3">Reset</button>
            </div>
        </form>
      </div>
      <?php else: ?>
        <h2 class="text-center">Maximum Instructors Reached</h2>
        <p class="text-center">You have reached the maximum number of instructors allowed.</p>
        <button class="btn btn-primary mb-3" onclick="window.location.href='instructorDeletePaswordChk.php';">Delete Insructor</button>
        <?php endif; ?>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
