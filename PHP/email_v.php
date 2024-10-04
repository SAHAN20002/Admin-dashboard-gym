<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verification-container {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            margin: auto;
            margin-top: 50px;
        }
        .verification-container h2 {
            margin-bottom: 20px;
        }
        .code-input {
            letter-spacing: 10px;
            font-size: 1.5rem;
            text-align: center;
            border-radius: 5px;
        }
        .resend-text {
            margin-top: 10px;
            font-size: 0.9rem;
            text-align: center;
        }
        .resend-btn {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            padding: 0;
        }
        .resend-btn:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="verification-container">
            <h2 class="text-center">Verify Your Email</h2>
            <p class="text-center">Please enter the 4-digit code sent to your email address.</p>
            <form method="POST" action="verify_code.php">
                <div class="mb-4 text-center">
                    <input type="text" class="form-control code-input" maxlength="4" placeholder="____" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Verify Code</button>
            </form>
            <div class="resend-text">
                Didn’t receive the code? <button class="resend-btn" onclick="resendCode()">Resend</button>
            </div>
        </div>
    </div>

    <script>
        function resendCode() {
            alert("A new code has been sent to your email!");
            // You can replace this with actual logic to resend the code.
        }
    </script>
</body>
</html>
