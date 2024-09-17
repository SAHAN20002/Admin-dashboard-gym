<?php 
include 'phpcon.php';

// Get the user ID from the request
$userId = $_GET['userId'];

// Prepare the first SQL query to fetch the payment slip
$query = "SELECT payment_slip FROM users WHERE user_id = ?";
$stmt = $conn->prepare($query);
if ($stmt) {
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($payment_slip);
    $stmt->fetch();
    $stmt->close();
} else {
    // Error handling for SQL query failure
    echo json_encode(['error' => 'Error fetching payment slip.']);
    exit();
}

// Prepare the second SQL query to fetch the membership cost
$queryMembership = "SELECT cost FROM membership_user WHERE user_id = ?";
$stmtMembership = $conn->prepare($queryMembership);
if ($stmtMembership) {
    $stmtMembership->bind_param("s", $userId);
    $stmtMembership->execute();
    $stmtMembership->bind_result($cost);
    $stmtMembership->fetch();
    $stmtMembership->close();
} else {
    // Error handling for SQL query failure
    echo json_encode(['error' => 'Error fetching membership cost.']);
    exit();
}

// Set the content type to JSON
header('Content-Type: application/json');

// Prepare the response array
$response = array();
if ($payment_slip) {
    $response['photo_link'] = $payment_slip; 
     $response['cost'] = $cost; // The correct variable name is $cost
} else {
    $response['photo_link'] = null;
    $response['cost'] = null; // No payment slip found
    $response['error'] = "No payment slip found for this user."; // Optional error message
}

// Output the JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
