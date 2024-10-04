<?php
// Example: Fetch members from the database
 $members = [ 
     ['id' => 1, 'name' => 'Instructor 1', 'email' => 'instructor1@example.com'], 
     ['id' => 2, 'name' => 'Instructor 2', 'email' => 'instructor2@example.com'],
     ['id' => 3, 'name' => 'Instructor 3', 'email' => 'instructor3@example.com']
 ];

// Limit to 3 members
$max_members = 3;
$current_members_count = 3;
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
        <form method="POST" action="your_backend_script.php">
            <div class="mb-3">
                <label for="I_ID" class="form-label">Instructor ID</label>
                <input type="text" class="form-control" id="I_Id" name="Instructor ID" required disabled>
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
                <input type="c_password" class="form-control" id="c_password" name=" Confirm password" required>
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
            </div>
        </form>
      </div>
      <?php else: ?>
        <div class="card-container">
            <h2 class="text-center">Instructor List (Max 3 Members)</h2>
            <div class="row">
                <?php foreach ($members as $member): ?>
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $member['name'] ?></h5>
                            <p class="card-text"><?= $member['email'] ?></p>
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
        <?php endif; ?>   
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
