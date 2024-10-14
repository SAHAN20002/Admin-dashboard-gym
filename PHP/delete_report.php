<?php
include 'phpcon.php';
if(isset($_POST['report_name'])){
    $id = $_POST['report_name'];
    $sql = "DELETE FROM generated_reports WHERE report_name = '$id'";
    $result = mysqli_query($conn, $sql);
    if($result){
        echo "<script>alert('Report Deleted Successfully'); window.history.back();</script>";
    }else{
        echo "Failed to Delete Report";
    }
}

?>