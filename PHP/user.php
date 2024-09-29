<?php
include 'phpcon.php';
session_start();
if (!isset($_SESSION['NIC'])) {
  header('location:login.php');
}
$userNic = $_SESSION['NIC'];

$sql = "SELECT * FROM instrutor WHERE NIC ='$userNic'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();


  $instructorName = $row['user_name'];
  $instructorNIC = $row['NIC'];
  $instructorAge = $row['age'];
  $instructorEmail = $row['email'];
  $instructorContact = $row['p_number'];
  $instructorID = $row['Instrutor_ID'];
  $instructorDescription = $row['description'];

 if(isset($_POST['update'])){
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $age = isset($_POST['age']) ? $_POST['age'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';

    $sql = "UPDATE instrutor SET user_name='$name', age='$age', email='$email', p_number='$contact', description='$description' WHERE NIC='$userNic'";
    if ($conn->query($sql) === TRUE) {
      echo 'success';
    } else {
      echo 'error';
    }
    $conn->close();
 }


?>












<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Profile</title>
  <!-- <link rel="stylesheet" href="user.css"> -->
  <!-- <script defer src="JS/user.js"></script> -->
  <style>
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
  </style>
</head>

<body>

  <div class="admin-panel">
    <header>
      <h1>Instructor Profile</h1>
    </header>

    <button id="back-button" onclick="window.history.back()">Back</button>

    <!-- Logo Image -->
    <div class="logo-container">
      <img id="logo" src="../IMG/gym copy.png" alt="Logo">
    </div>

    <main>
      <section class="user-profile">
        <div class="profile-header">
          <div class="profile-image">
            <img id="profile-picture" src="../IMG/user.jpg" alt="User Profile Picture">
            <input type="file" id="profile-input" style="display: none;" accept="image/*">
          </div>
          <div class="profile-info">
            <h2 id="username"><?php echo $instructorName?></h2>
            <p>User ID: <span id="user-id"><?php echo $instructorID?></span></p>
            <p>User NIC: <span id="user-id"><?php echo $instructorNIC?></span></p>
          </div>
        </div>

        <!-- Personal Details -->
        <div class="profile-details">
          <h3>Profile Information</h3>
          
          <div class="info-row">
            <label for="Username">User Name:</label>
            <input type="text" id="Username" value="<?php echo $instructorName ?> " disabled>
          </div>
          <div class="info-row">
            <label for="email">Email:</label>
            <input type="email" id="email" value="<?php echo $instructorEmail ?>" disabled>
          </div>
          <div class="info-row">
            <label for="contact">Contact No:</label>
            <input type="text" id="contact" value="<?php echo $instructorContact ?>" disabled>
          </div>
          <div class="info-row">
            <label for="Age">Age:</label>
            <input type="text" id="Age" value="<?php echo $instructorAge ?>" disabled>
          </div>
          <div class="info-row">
            <label for="Description">Description:</label>
            <input type="text" id="Description" value="<?php echo $instructorDescription ?>" disabled>
          </div>
        </div>

        <!-- Bank Details Section -->
        <!-- <div class="bank-details">
          <h3>Bank Information</h3>

          <div class="info-row">
            <label for="bank-name">Bank Name:</label>
            <input type="text" id="bank-name" value="Bank of ranil" disabled>
          </div>
          <div class="info-row">
            <label for="account-number">Account Number:</label>
            <input type="text" id="account-number" value="123456789" disabled>
          </div>
          <div class="info-row">
            <label for="routing-number">Routing Number:</label>
            <input type="text" id="routing-number" value="987654321" disabled>
          </div>
        </div> -->

        <div class="profile-actions">
          <button id="edit-profile">Edit Profile</button>
          <button id="save-profile" style="display: none;">Save Profile</button>
        </div>
      </section>
    </main>
  </div>
  <script>

      let instructorName = "<?php echo $instructorName ?>";
      let instructorAge = "<?php echo $instructorAge ?>";
      let instructorEmail = "<?php echo $instructorEmail ?>";
      let instructorContact = "<?php echo $instructorContact ?>";
      let instructorDescription = "<?php echo $instructorDescription ?>";

    let E_instructorName = document.getElementById('Username');
    let E_instructorAge = document.getElementById('Age');
    let E_instructorEmail = document.getElementById('email');
    let E_instructorContact = document.getElementById('contact');
    let E_instructorDescription = document.getElementById('Description');


    // Selecting the DOM elements
    const editButton = document.getElementById('edit-profile');
    const saveButton = document.getElementById('save-profile');
    const deleteButton = document.getElementById('delete-profile');
    const profilePicture = document.getElementById('profile-picture');
    const profileInput = document.getElementById('profile-input');
    const inputs = document.querySelectorAll('.profile-details input');

    // Enable edit mode
    editButton.addEventListener('click', function () {
      inputs.forEach(input => {
        input.disabled = false;
      });
      editButton.style.display = 'none';
      saveButton.style.display = 'inline-block';
      alert(instructorName);

      // Enable profile picture click to upload
      // profilePicture.addEventListener('click', function () {
      //   profileInput.click();
      // });
    });

    // Handle profile photo change
    //  profileInput.addEventListener('change', function (event) {
    //    const file = event.target.files[0];
    //    if (file) {
    //      const reader = new FileReader();
    //      reader.onload = function (e) {
    //        profilePicture.src = e.target.result; // Update profile picture
    //      };
    //      reader.readAsDataURL(file);
    //    }
    //  });

    // Save profile changes
    saveButton.addEventListener('click', function () {
      inputs.forEach(input => {
        input.disabled = true;
      });
      editButton.style.display = 'inline-block';
      saveButton.style.display = 'none';

      let updatedName = E_instructorName.value.trim();
      let updatedAge = E_instructorAge.value.trim();
      let updatedEmail = E_instructorEmail.value.trim();
      let updatedContact = E_instructorContact.value.trim();
      let updatedDescription = E_instructorDescription.value.trim();

      if (
        (updatedName && updatedName !== instructorName) ||
        (updatedAge && updatedAge !== instructorAge) ||
        (updatedEmail && updatedEmail !== instructorEmail) ||
        (updatedContact && updatedContact !== instructorContact) ||
        (updatedDescription && updatedDescription !== instructorDescription)
      ) {
        let formData = new FormData();

        formData.append('name', updatedName);
        formData.append('age', updatedAge);
        formData.append('email', updatedEmail);
        formData.append('contact', updatedContact);
        formData.append('description', updatedDescription);
        formData.append('update', 'update');

        fetch('user.php', {
          method: 'POST',
          body: formData
        }).then(response => response.text())
          .then(data => {
            if (data.includes('success')) {
              window.location.reload();
              alert('Profile updated successfully');
              instructorName = updatedName;
              instructorAge = updatedAge;
              instructorEmail = updatedEmail;
              instructorContact = updatedContact;
              instructorDescription = updatedDescription;
            } else {
              alert('Failed to update the profile');
            }
          }).catch(error => {
            console.error('Error:', error);
            alert('An error occurred while updating the profile');
          });

        }
      });
  </script>
</body>

</html>