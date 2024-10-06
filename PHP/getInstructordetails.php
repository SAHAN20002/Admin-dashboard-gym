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
    $sql = "SELECT * FROM instructor_show WHERE Instructor_Id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $plan);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch data as an associative array
        $row = $result->fetch_assoc();
        echo json_encode([
            'planDuration' => $row['Name'],
            'planPrice' => $row['price'],
            'benefit1' => $row['description']
            
        ]);
    } else {
        echo json_encode(['error' => 'No data found']);
    }

    
}
if (isset($_POST['action']) && $_POST['action'] === 'changeStatus') {
    
    $updateSql = "UPDATE instrutor SET Chnage_status = false";
    if ($conn->query($updateSql) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $conn->error]);
    }
}
    $stmt->close();
    $conn->close();

?>
