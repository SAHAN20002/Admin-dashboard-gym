<?php
include 'phpcon.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['text']) && $data['text'] == 'search') {
        $search = $data['search'];

        $sqlSearch = "SELECT * FROM zoom_clz WHERE Id LIKE '%$search%' ";
        $result = $conn->query($sqlSearch);

        if ($result->num_rows > 0) {
            // Fetch data as an associative array
            $row = $result->fetch_assoc();
            echo json_encode([
                'Clz_Id' => $row['Id'],
                'Topic' => $row['Topic'],
                'Instructor_name' => $row['Instructor_name'],
                'time' => $row['Time'],
                'date' => $row['date'],
                'link' => $row['Link']
            ]);
        } else {
            echo json_encode(['error' => 'No data found']);
        }
    } else {
        echo json_encode(['error' => 'Invalid request']);
    }
}
    
   

?>