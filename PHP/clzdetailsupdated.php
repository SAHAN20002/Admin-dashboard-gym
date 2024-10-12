<?php
include 'phpcon.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
   
    $classId = isset($_POST['C_I']) ? $_POST['C_I'] : '';
    $topic = isset($_POST['T_P']) ? $_POST['T_P'] : '';
    $instructorName = isset($_POST['I_N']) ? $_POST['I_N'] : '';
    $startTime = isset($_POST['S_T']) ? $_POST['S_T'] : '';
    $date = isset($_POST['D_A']) ? $_POST['D_A'] : '';
    $link = isset($_POST['L_K']) ? $_POST['L_K'] : '';
    

   
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    
    if (isset($_POST['sumbit'])) {
       
        $sql = "INSERT INTO zoom_clz (Id, Topic, Instructor_name, Time, date, Link) 
                VALUES ('$classId','$topic', '$instructorName', '$startTime', '$date', '$link')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('New class successfully created');</script>";
           
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['delete'])) {
       
        $sql = "DELETE FROM classes WHERE class_id = '$classId'";

        if ($conn->query($sql) === TRUE) {
            echo "Class successfully deleted";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } elseif (isset($_POST['updated'])) {
       
        $sql = "UPDATE classes SET 
                topic = '$topic', 
                instructor_name = '$instructorName', 
                start_time = '$startTime', 
                date = '$date', 
                link = '$link' 
                WHERE class_id = '$classId'";

        if ($conn->query($sql) === TRUE) {
            echo "Class successfully updated";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    
    
}


    
   

?>