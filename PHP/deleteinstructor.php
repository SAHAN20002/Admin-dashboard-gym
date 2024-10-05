<?php
include 'phpcon.php';
include 'mailsend.php';


$instructor_Id = "";
session_start();



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
            <button class="btn btn-secondary mb-3" onclick="window.history.back();">Back</button>
            <div class="row">
                <?php foreach ($members as $member): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?=$member['name'] ?></h5>
                            <p class="card-text"><?=$member['email'] ?></p>
                            <form method="POST" action="delete_member.php">
                                <input type="hidden" name="member_id" value="<?= $member['id'] ?>">
                                <button type="submit" class="btn btn-danger w-100">Delete</button>
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
