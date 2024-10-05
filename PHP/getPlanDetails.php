<?php
include 'phpcon.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Database connection (replace with your details)
    
    
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $plan = $_POST['plan'];

    // Query to get plan details from the membership table
    $sql = "SELECT * FROM membership WHERE p_id  = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $plan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch data as an associative array
        $row = $result->fetch_assoc();
        echo json_encode([
            'planDuration' => $row['name'],
            'planPrice' => $row['price'],
            'benefit1' => $row['benefits_1'],
            'benefit2' => $row['benefits_2'],
            'benefit3' => $row['benefits_3'],
            'benefit4' => $row['benefits_4'],
            'benefit5' => $row['benefits_5']
        ]);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    $stmt->close();
    $conn->close();
}
?>
