<?php
include 'phpcon.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the JSON input from the fetch request
    $data = json_decode(file_get_contents('php://input'), true);

    // Check if 'id' and 'text' parameters are set
    if (isset($data['id']) && $data['text'] === 'delete') {
        $id = intval($data['id']);

       
        
        $sql = "DELETE FROM zoom_clz WHERE Id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            // Return a success response
            echo json_encode(['success' => true]);
        } else {
            // Return an error message
            echo json_encode(['error' => 'Failed to delete class.']);
        }

        $stmt->close();
        $conn->close();
    } else {
        echo json_encode(['error' => 'Invalid input.']);
    }
} else {
    echo json_encode(['error' => 'Invalid request method.']);
}
?>
