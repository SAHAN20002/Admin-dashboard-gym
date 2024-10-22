<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Disabled</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .disabled-account-container {
            background-color: #fff;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 400px;
        }

        .disabled-account-container h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #dc3545;
        }

        .disabled-account-container p {
            font-size: 16px;
            color: #555;
            margin-bottom: 30px;
        }

        .disabled-account-container .btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
        }

    </style>
</head>
<body>

    <div class="disabled-account-container">
        <h1>Your Account Has Been Disabled</h1>
        <p>Your account has been disabled by the admin. If you believe this is an error, please contact support for assistance.</p>
        <a href="" id="show_contact" class="btn btn-primary mb-3">Contact Support</a>
        <a href="index.php" class="btn btn-secondary">Return to Homepage</a>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('show_contact').addEventListener('click', function() {
            alert('Please contact support at 070 341 1511');
        });
    </script>
</body>
</html>
